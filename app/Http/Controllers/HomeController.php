<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\FieldService;
use App\Models\Meeting;
use App\Models\Publisher;
use App\Models\PublisherServiceType;
use App\Models\YearService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalPublishers = Publisher::all()->count();
        $totalPioneers = PublisherServiceType::where('service_type_id', 4)->get()->count();

        $lastMonth = date('m') - 1;
        // $lastMonth = 9;

        $dt =  sprintf('%s-%s-%s', date('Y'), str_pad($lastMonth, 2, '0', STR_PAD_LEFT), '01');
        $yearService = YearService::
                    whereRaw('"'.$dt.'" >= start_at')
                    ->whereRaw('"'.$dt.'" <= finish_at')
                    ->first();
        $totalReports = FieldService::where('year_service_id', $yearService->id)
            ->where('month', $lastMonth)
            ->get()->count();
        
        $irregularDate = Carbon::createFromFormat("!Y-m-d", $dt);
        $irregularDate->subMonth(6);

        $irregularDateYs = YearService::
                    whereRaw('"'.$irregularDate->format('Y-m-d').'" >= start_at')
                    ->whereRaw('"'.$irregularDate->format('Y-m-d').'" <= finish_at')
                    ->first();
        
        $totalIrregular = DB::select("SELECT count(1) as total FROM publishers p
            left join ( 
                select s.publisher_id, s.month as last_month 
                from field_services s 
                where s.created_at > '" . $irregularDate->format('Y-m-d H:i:s') . "' 
                and s.hours is not null 
                order by id desc) S on p.id = S.publisher_id
            where S.publisher_id is null")[0]->total;

        $totalNonBaptizedPublishers = Publisher::whereNull('baptize_date')->count();

        $groups = Group::orderBy('name', 'ASC')->get();
        $membersGroups = [];
        $colors = ['yellow', 'purple', 'green',  'blue'];
        $i = 0; 
        foreach ($groups as $g) {

            $members = $g->members()->count();
            
            $membersGroups[$g->name] = [
                'color' => $colors[$i],
                'total' => $members
            ];
            $i++;
            
        }

        // pioneers activity
        $regularPioneers = FieldService::where('year_service_id', $yearService->id)
            ->where('month', $lastMonth)
            ->where('service_type_id', 4)
            ->whereNotNull('hours')
            ->get();
        
        $auxiliarPioneers = FieldService::where('year_service_id', $yearService->id)
            ->where('month', $lastMonth)
            ->whereIn('service_type_id', [2,3])
            ->whereNotNull('hours')
            ->get();

        $publishers = FieldService::where('year_service_id', $yearService->id)
            ->where('month', $lastMonth)
            ->where('service_type_id', 1)
            ->whereNotNull('hours')
            ->get();
        
        $pendingReports = $totalPublishers - $totalReports;

        $meetingsLastMonthIniDate = Carbon::createFromFormat("!Y-m-d", $dt);
        $meetingsLastMonthEndDate = Carbon::createFromFormat("!Y-m-d", $dt);
        $meetingsLastMonthEndDate->addMonth(1);

        $weekendMeeting = Meeting::whereRaw('weekday(date) in (5,6)')
            ->whereNotNull('attendance')
            ->where('date', '>=', $meetingsLastMonthIniDate->format('Y-m-d'))
            ->where('date', '<', $meetingsLastMonthEndDate->format('Y-m-d'))
            ->get();

        $midweekMeeting = Meeting::whereRaw('weekday(date) in (0,1,2,3,4)')
            ->whereNotNull('attendance')
            ->where('date', '>=', $meetingsLastMonthIniDate->format('Y-m-d'))
            ->where('date', '<', $meetingsLastMonthEndDate->format('Y-m-d'))
            ->get();

        $reminders = $this->reminders();
        $reportedMonth = clone $meetingsLastMonthIniDate;
        
        return view('home', compact(
            'totalPublishers', 
            'totalPioneers', 
            'totalReports', 
            'totalNonBaptizedPublishers', 
            'totalIrregular', 
            'pendingReports', 
            'membersGroups', 
            'regularPioneers', 
            'auxiliarPioneers', 
            'publishers', 
            'lastMonth',
            'weekendMeeting',
            'midweekMeeting',
            'reminders',
            'reportedMonth'
        ));
    }

    public function reminders()
    {
        $arrayReminders = [];
        $today = Carbon::today();


        // limit date to send month report for bethel
        $currentMonth = date('m');
        $dt =  sprintf('%s-%s-%s', date('Y'), str_pad($currentMonth, 2, '0', STR_PAD_LEFT), '20');
        $reportLimitDate = Carbon::createFromFormat("!Y-m-d", $dt);

        if ($today->lte($reportLimitDate) and $today->diffInDays($reportLimitDate) < 5) {

            if ($today->diffInDays($reportLimitDate) == 0) {
                $arrayReminders[] = sprintf('Atenção!!!! Hoje é o último dia para enviar os relatórios para Betel.');
            } else {
                $arrayReminders[] = sprintf('Faltam %s dias para enviar os relatórios do mês para Betel!', $today->diffInDays($reportLimitDate));
            }

        }

        // first year of baptized publishers
        $publishers = Publisher::whereNotNull('baptize_date')
            ->whereRaw('baptize_date between DATE_SUB(curdate(),INTERVAL 1 YEAR) and DATE_SUB(curdate(),INTERVAL 11 MONTH)')
            ->get();
        
        foreach ($publishers as $p) {
            $arrayReminders[] = sprintf('Dê os parabéns pelo seu um ano de batizmo a(o) %s que se batizou em %s', $p->name, $p->baptize_date->format('d/m/Y'));
        }

        return $arrayReminders;
    }
}
