<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\FieldService;
use App\Models\Publisher;
use App\Models\YearService;
use App\Traits\DateTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class NonReportedController extends Controller
{
    use DateTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    private function report($groupId = null)
    {
        $lastMonth = date('m') - 1;

        $dt =  sprintf('%s-%s-%s', date('Y'), str_pad($lastMonth, 2, '0', STR_PAD_LEFT), '01');

        $yearService = YearService::whereRaw('"'.$dt.'" >= start_at')
            ->whereRaw('"'.$dt.'" <= finish_at')
            ->first();
            
        $irregulars = DB::table('publishers AS p')
            ->leftJoin('groups AS g', 'g.id', '=', 'p.group_id')
            ->leftJoin('field_services AS f', function ($join) use ($yearService, $lastMonth) {
                $join->on('f.publisher_id', '=', 'p.id');
                $join->on('f.year_service_id', '=', DB::raw($yearService->id));
                $join->on('f.month', '=', DB::raw($lastMonth));
            })
            ->selectRaw('p.name AS publisher_name, g.name AS group_name, f.hours')
            ->whereRaw('f.id is null')
            ->orderBy('g.name', 'ASC')
            ->orderBy('p.name', 'ASC');

        if ($groupId) {
            return $irregulars->where('g.id', $groupId)->get();
        }

        return $irregulars->get();
    }

    public function index()
    {
        $groups = Group::all();
        $irregulars = $this->report();

        return view('non_reported/index', compact('irregulars', 'groups'));
    }

    public function generate(Request $request)
    {
        // dd($request);
        $irregulars = $this->report($request->group_id);

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=irregular.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columns = array('NOME');

        $callback = function() use ($irregulars, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            $group_name = '';
            foreach($irregulars as $item) {
                fputcsv($file, array(
                    $item->publisher_name
                ));
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
        
    }
}