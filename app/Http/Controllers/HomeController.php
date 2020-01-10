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
        $totalMinister = Publisher::all()->count();

        $lastMonth = date('m') - 1;
        // $lastMonth = 9;

        if (date('m') == 1) {
            $lastMonth = 12;
            $year = date('Y') - 1;
        } else {
            $lastMonth = date('m') - 1;
            $year = date('Y');
        }

        $dt =  sprintf('%s-%s-%s', $year, str_pad($lastMonth, 2, '0', STR_PAD_LEFT), '01');
        $yearService = YearService::
                    whereRaw('"'.$dt.'" >= start_at')
                    ->whereRaw('"'.$dt.'" <= finish_at')
                    ->first();
        $totalReports = FieldService::where('year_service_id', $yearService->id)
            ->where('month', $lastMonth)
            ->get()->count();

        $totalNonBaptizedPublishers = Publisher::whereNull('baptize_date')->count();

        $inactives = DB::select("SELECT p.id, p.name, sum(fs.hours) as total_hours 
            FROM publishers p
            LEFT JOIN (
                SELECT publisher_id, hours FROM field_services WHERE date_ref >= (DATE_SUB(curdate(), INTERVAL 7 MONTH))
            ) AS fs ON fs.publisher_id = p.id
            WHERE p.baptize_date IS NOT NULL
            GROUP BY 1, 2
            HAVING SUM(fs.hours) IS NULL");
        $totalInactives = count($inactives);

        $irregulars = DB::select("SELECT COUNT(DISTINCT publisher_id) AS total FROM field_services
            WHERE hours IS NULL
            AND date_ref >= DATE_SUB(CURDATE(), INTERVAL 5 MONTH)");
        $totalIrregular = $irregulars[0]->total - $totalInactives;

        $totalElderly = Publisher::where('privilege', 'OM')->count();
        $totalMinisterialServants = Publisher::where('privilege', 'MS')->count();
        $totalRegularPioneers = PublisherServiceType::where('service_type_id', 4)->get()->count();
        $totalAuxiliarPioneers = PublisherServiceType::where('service_type_id', 3)->whereNull('finish_at')->count();

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
        
        $pendingReports = $totalMinister - $totalReports;

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
            'totalMinister', 
            'totalNonBaptizedPublishers', 
            'totalIrregular', 
            'totalInactives',
            
            'totalElderly',
            'totalMinisterialServants',
            'totalRegularPioneers', 
            'totalAuxiliarPioneers',
            
            'totalReports', 
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
