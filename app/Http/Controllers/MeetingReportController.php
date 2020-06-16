<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\YearService;
use App\Traits\DateTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PDF;
use Yajra\Datatables\Datatables;

class MeetingReportController extends Controller
{
    use DateTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ajaxData() 
    {
        $builder = YearService::orderBy('start_at', 'DESC');

        $dt = new Datatables();
        return $dt->eloquent($builder)

            ->addColumn('year', function($item) {
                return sprintf('%s/%s', $item->start_at->format('Y'), $item->finish_at->format('Y'));
            })

            ->addColumn('action', function($item) {
                $html = "";
                $html .= '<a class="btn btn-social-icon" data-toggle="tooltip" title="Exportar relatorio" href="' . route('meeting_report.report', $item->id) . '" target="_blank">
                    <i class="fa fa-cloud-download text-blue"></i>
                </a>';
                return $html;
            })

            ->rawColumns([
                'action'
            ])
            ->make();
    }

    public function index()
    {
        return view('meeting_report/index');
    }

    public function report(Request $req, $yearServiceId)
    {
        $yearService = YearService::where('id', $yearServiceId)->first();

        $arrayMonth = [
            9 => 'Setembro', 
            10 => 'Outubro', 
            11 => 'Novembro', 
            12 => 'Dezembro', 
            1 => 'Janeiro', 
            2 => 'Fevereiro', 
            3 => 'Março', 
            4 => 'Abril', 
            5 => 'Maio', 
            6 => 'Junho', 
            7 => 'Julho', 
            8 => 'Agosto'
        ];
            
        $array = [
            'period' => sprintf('%s/%s', $yearService->start_at->format('Y'), $yearService->finish_at->format('Y')),
            'midweek' => [],
            'weekend' => [],
        ];

        foreach ($arrayMonth as $key => $value) {
            if ($key > 8) {
                $dt = sprintf('%s-%s-%s', $yearService->start_at->format('Y'), str_pad($key, 2, '0', STR_PAD_LEFT), '01');
            } else {
                $dt = sprintf('%s-%s-%s', $yearService->finish_at->format('Y'), str_pad($key, 2, '0', STR_PAD_LEFT), '01');
            }

            $meetingsIniDate = Carbon::createFromFormat("!Y-m-d", $dt);
            $meetingsEndDate = Carbon::createFromFormat("!Y-m-d", $dt);
            $meetingsEndDate->addMonth(1);
    
            $wkData = $this->weekendMeetings($meetingsIniDate, $meetingsEndDate);
            $array['weekend'][] = [
                'month' => $value,
                'total_meetings' => $wkData['total_meetings'],
                'total_attendance' => $wkData['total_attendance'],
                'avg_meetings' => $wkData['avg_meetings']
            ];

            $mkData = $this->midweekMeetings($meetingsIniDate, $meetingsEndDate);
            $array['midweek'][] = [
                'month' => $value,
                'total_meetings' => $mkData['total_meetings'],
                'total_attendance' => $mkData['total_attendance'],
                'avg_meetings' => $mkData['avg_meetings']
            ];

        }

        // dd($array); 
        // return view('meeting_report/report', ['meetings' => $array]);
        $pdf = PDF::loadView('meeting_report/report', ['meetings' => $array]);  
        return $pdf->download(sprintf('Meetings - %s.pdf', $array['period']));

    }

    private function weekendMeetings($meetingsIniDate, $meetingsEndDate)
    {
        $weekendMeeting = Meeting::whereRaw('weekday(date) in (5,6)')
            ->whereNotNull('attendance')
            ->where('date', '>=', $meetingsIniDate->format('Y-m-d'))
            ->where('date', '<', $meetingsEndDate->format('Y-m-d'))
            ->get();

        return [
            'total_meetings' => ($weekendMeeting->count() > 0) ? $weekendMeeting->count() : 0,
            'total_attendance' => ($weekendMeeting->count() > 0) ? $weekendMeeting->sum('attendance') : 0,
            'avg_meetings' => ($weekendMeeting->count() > 0) ? round($weekendMeeting->sum('attendance') / $weekendMeeting->count(), 2) : 0,
        ];        
    }

    private function midweekMeetings($meetingsIniDate, $meetingsEndDate)
    {
        $midweekMeetings = Meeting::whereRaw('weekday(date) in (0,1,2,3,4)')
            ->whereNotNull('attendance')
            ->where('date', '>=', $meetingsIniDate->format('Y-m-d'))
            ->where('date', '<', $meetingsEndDate->format('Y-m-d'))
            ->get();

        return [
            'total_meetings' => ($midweekMeetings->count() > 0) ? $midweekMeetings->count() : 0,
            'total_attendance' => ($midweekMeetings->count() > 0) ? $midweekMeetings->sum('attendance') : 0,
            'avg_meetings' => ($midweekMeetings->count() > 0) ? round($midweekMeetings->sum('attendance') / $midweekMeetings->count(), 2) : 0,
        ];        
    }
}