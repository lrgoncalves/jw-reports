<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\FieldService;
use App\Models\Publisher;
use App\Models\ServiceType;
use App\Models\YearService;
use App\Traits\DateTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PDF;
use Yajra\Datatables\Datatables;

class PublisherFieldServiceReportController extends Controller
{
    use DateTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    private function getReport($publisherId = null, $yearServiceId = null, $limit = 1)
    {
        if (!$publisherId) {
            $yS = YearService::orderBy('finish_at', 'DESC');
            
            if ($yearServiceId) {
                $yS->where('id', $yearServiceId);
            }
            $yS->limit(1);
            $yearServices = $yS->get();
            $publishers = Publisher::orderBy('name', 'ASC')->get();
        } else {
            $yS = YearService::orderBy('finish_at', 'DESC');
            
            if ($yearServiceId) {
                $yS->where('id', $yearServiceId);
            }

            if ($limit === 0) {
                $yearServices = $yS->get();
            } else {
                $yearServices = $yS->limit($limit)->get();
            }
            
            $publishers = Publisher::where('id', $publisherId)->orderBy('name', 'ASC')->get();
        }

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

        $arrayCard = [];
        foreach ($publishers as $p) {

            $isRegularPioneer = $p->serviceType()
                ->where('start_at', '<=', date('Y-m-d'))
                ->whereNull('finish_at')
                ->where('service_type_id', ServiceType::REGULAR_PIONEER)
                ->first();

            $years = [];
            foreach ($yearServices as $y) {

                $arrayReport = [];
                foreach ($arrayMonth as $key => $month) {
                    $monthData = FieldService::where('year_service_id', $y->id)
                        ->where('month', $key)
                        ->where('publisher_id', $p->id)
                        ->first();

                    $observations = null;
                    if ($monthData) {
                        if ($monthData->observations) {
                            $observations = $monthData->observations;
                        } else if ($monthData->service_type_id == ServiceType::AUXILIAR_PIONNER_30) {
                            $observations = 'Pioneiro auxiliar 30h';
                        } else if ($monthData->service_type_id == ServiceType::AUXILIAR_PIONEER_50) {
                            $observations = 'Pioneiro auxiliar 50h';
                        }
                    }
                    
                    $arrayReport[] = [
                        'month' => $month,
                        'field_service_id' => (!$monthData) ? null : $monthData->id,
                        'placements' => (!$monthData) ? null : $monthData->placements,
                        'videos' => (!$monthData) ? null : $monthData->videos,
                        'hours' => (!$monthData) ? null : $monthData->hours,
                        'return_visits' => (!$monthData) ? null : $monthData->return_visits,
                        'studies' => (!$monthData) ? null : $monthData->studies,
                        'observations' => $observations,
                    ];
                }
                
                $years[] = [
                    'period' => sprintf('%s/%s', $y->start_at->format('Y'), $y->finish_at->format('Y')),
                    'report' => $arrayReport,
                ];
            }

            $arrayCard[] = [
                'name' => $p->name,
                'gender' => $p->gender,
                'group' => $p->group()->first()->name,
                'birthdate' => ($p->birthdate) ? $p->birthdate->format('d/m/Y') : null,
                'baptize' => ($p->baptize_date) ? $p->baptize_date->format('d/m/Y') : null,
                'anointed' => $p->anointed,
                'regular_pioneer' => (!is_null($isRegularPioneer)),
                'privilege' => $p->privilege,
                'year_services' => $years
            ];
        }

        return $arrayCard;
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
                $html .= '<a class="btn btn-social-icon" data-toggle="tooltip" title="Exportar relatorio" href="' . route('publisher_field_service_report.generate', $item->id) . '" target="_blank">
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
        return view('publisher_field_service_report/index');
    }

    public function generate(Request $request, $yearServiceId)
    {
        set_time_limit(0);
        $inactives = DB::select("SELECT p.id, sum(fs.irregular) as total_irregular 
                        FROM publishers p
                        LEFT JOIN (
                            SELECT publisher_id, irregular FROM field_services WHERE date_ref >= (DATE_SUB(curdate(), INTERVAL 7 MONTH))
                        ) AS fs ON fs.publisher_id = p.id
                        -- WHERE p.baptize_date IS NOT NULL
                        GROUP BY 1
                        HAVING SUM(fs.irregular) > 5");
        $ids = [];
        foreach ($inactives as $i) {
            $ids[] = $i->id;
        }

        $actives = Publisher::whereNotIn('id', $ids)
            ->orderBy('name', 'ASC')
            ->pluck('id');

        $yearsPerPage = 1;
        $data = [];
        foreach ($actives as $pbId) {
            $data[] = $this->getReport($pbId, $yearServiceId, $yearsPerPage)[0];
        }
        
        // return view('publisher_field_service_report/congregation_report', ['data' => $data]);
        $pdf = PDF::loadView('publisher_field_service_report/congregation_report', ['data' => $data]); 
        return $pdf->download(sprintf('%s.pdf', Str::slug('congregation_field_service')));
    }

    public function report(Request $request, $publisherId = null) 
    {
        if ($publisherId) {
            $data = $this->getReport($publisherId, null, 0);
        } else {
            $data = $this->getReport($publisherId, null, 1);
        }

        $publisherData = $data[0];
        unset($publisherData['year_services']);
        $yearServices = $data[0]['year_services'];

        
        $totalPages = ceil(count($yearServices) / 2);
        $arrayPages = [];
        
        
        $idxPage = 0;
        for ($i=0; $i < count($yearServices); $i++) { 
            $arrayPages[$idxPage][] = $yearServices[$i];

            if (count($arrayPages[$idxPage]) > 1) {
                $idxPage++;
            }

        }
        
        $array = [
            'publisherData' => $publisherData,
            'arrayPages' => $arrayPages
        ];
        // dd($publisherData, $arrayPages);

        // return view('publisher_field_service_report/report', $array);
        $pdf = PDF::loadView('publisher_field_service_report/report', $array);  
        return $pdf->download(sprintf('%s.pdf', Str::slug($publisherData['name'])));
    }
}