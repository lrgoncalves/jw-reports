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
            ->get();
        
        $auxiliarPioneers = FieldService::where('year_service_id', $yearService->id)
            ->where('month', $lastMonth)
            ->whereIn('service_type_id', [2,3])
            ->get();

        $publishers = FieldService::where('year_service_id', $yearService->id)
            ->where('month', $lastMonth)
            ->where('service_type_id', 1)
            ->get();
        
        $pendingReports = $totalPublishers - $totalReports;

        $weekendMeeting = Meeting::whereRaw('weekday(date) in (5,6)')->get();
        $midweekMeeting = Meeting::whereRaw('weekday(date) in (0,1,2,3,4)')->get();

        // dd($weekendMeeting, $midweekMeeting->avg('attendance'));

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
            'midweekMeeting'
        ));
    }
}
