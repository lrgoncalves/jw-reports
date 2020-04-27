<?php

namespace App\Http\Controllers;

use App\Models\FieldService;
use App\Models\YearService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Str;
use PDF;

class CongregationActivityReportController extends Controller
{

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
                $html .= '<a class="btn btn-social-icon" data-toggle="tooltip" title="Exportar relatorio" href="' . route('congregation_activity_report.report', $item->id) . '" target="_blank">
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
        return view('congregation_activity_report/index');
    }

    public function report(Request $request, $yearServiceId) 
    {

        $yearServices = YearService::where('id', $yearServiceId)->get();

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

        $types = [];
        foreach ($yearServices as $y) {

            // publishers
            $arrayReport = [];
            foreach ($arrayMonth as $key => $month) {
                $monthData = FieldService::where('year_service_id', $y->id)
                    ->where('month', $key)
                    ->where('service_type_id', 1)
                    ->whereNotNull('hours')
                    ->get();
    
                $arrayReport[] = [
                    'month' => $month,
                    'placements' => (!$monthData) ? null : $monthData->sum('placements'),
                    'videos' => (!$monthData) ? null : $monthData->sum('videos'),
                    'hours' => (!$monthData) ? null : $monthData->sum('hours'),
                    'return_visits' => (!$monthData) ? null : $monthData->sum('return_visits'),
                    'studies' => (!$monthData) ? null : $monthData->sum('studies'),
                    'observations' =>  (!$monthData || $monthData->sum('hours') === 0) ? null : sprintf('Total de relatórios: %s', $monthData->count()),
                ];

            }

            $types[] = [
                'type' => 'Publicadores',
                'year_service' => sprintf('%s/%s', $y->start_at->format('Y'), $y->finish_at->format('Y')),
                'report' => $arrayReport,
            ];


            // auxiliar pioneers
            $arrayReport = [];
            foreach ($arrayMonth as $key => $month) {
                $monthData = FieldService::where('year_service_id', $y->id)
                    ->where('month', $key)
                    ->whereIn('service_type_id', [2,3])
                    ->whereNotNull('hours')
                    ->get();
    
                $arrayReport[] = [
                    'month' => $month,
                    'placements' => (!$monthData) ? null : $monthData->sum('placements'),
                    'videos' => (!$monthData) ? null : $monthData->sum('videos'),
                    'hours' => (!$monthData) ? null : $monthData->sum('hours'),
                    'return_visits' => (!$monthData) ? null : $monthData->sum('return_visits'),
                    'studies' => (!$monthData) ? null : $monthData->sum('studies'),
                    'observations' =>  (!$monthData || $monthData->sum('hours') === 0) ? null : sprintf('Total de relatórios: %s', $monthData->count()),
                ];

            }

            $types[] = [
                'type' => 'Pioneiros auxiliares',
                'year_service' => sprintf('%s/%s', $y->start_at->format('Y'), $y->finish_at->format('Y')),
                'report' => $arrayReport,
            ];


            // regular pioneers
            $arrayReport = [];
            foreach ($arrayMonth as $key => $month) {
                $monthData = FieldService::where('year_service_id', $y->id)
                    ->where('month', $key)
                    ->where('service_type_id', 4)
                    ->whereNotNull('hours')
                    ->get();
    
                $arrayReport[] = [
                    'month' => $month,
                    'placements' => (!$monthData) ? null : $monthData->sum('placements'),
                    'videos' => (!$monthData) ? null : $monthData->sum('videos'),
                    'hours' => (!$monthData) ? null : $monthData->sum('hours'),
                    'return_visits' => (!$monthData) ? null : $monthData->sum('return_visits'),
                    'studies' => (!$monthData) ? null : $monthData->sum('studies'),
                    'observations' =>  (!$monthData || $monthData->sum('hours') === 0) ? null : sprintf('Total de relatórios: %s', $monthData->count()),
                ];

            }

            $types[] = [
                'type' => 'Pioneiros regulares',
                'year_service' => sprintf('%s/%s', $y->start_at->format('Y'), $y->finish_at->format('Y')),
                'report' => $arrayReport,
            ];


            // all congregation
            $arrayReport = [];
            foreach ($arrayMonth as $key => $month) {
                $monthData = FieldService::where('year_service_id', $y->id)
                    ->where('month', $key)
                    ->whereNotNull('hours')
                    ->get();
    
                $arrayReport[] = [
                    'month' => $month,
                    'placements' => (!$monthData) ? null : $monthData->sum('placements'),
                    'videos' => (!$monthData) ? null : $monthData->sum('videos'),
                    'hours' => (!$monthData) ? null : $monthData->sum('hours'),
                    'return_visits' => (!$monthData) ? null : $monthData->sum('return_visits'),
                    'studies' => (!$monthData) ? null : $monthData->sum('studies'),
                    'observations' =>  (!$monthData || $monthData->sum('hours') === 0) ? null : sprintf('Total de relatórios: %s', $monthData->count()),
                ];

            }

            $types[] = [
                'type' => 'Congregação',
                'year_service' => sprintf('%s/%s', $y->start_at->format('Y'), $y->finish_at->format('Y')),
                'report' => $arrayReport,
            ];

        }

        // return view('congregation_activity_report/report', ['data' => $types]);
        $pdf = PDF::loadView('congregation_activity_report/report', ['data' => $types])
            ->setPaper('a4', 'portrait'); 
        return $pdf->download(sprintf('%s.pdf', Str::slug('publishers_addresses')));

    }
}