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

class PublisherFieldServiceReportController extends Controller
{
    use DateTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    private function getReport($publisherId = null)
    {
        $yearServices = YearService::orderBy('finish_at', 'ASC')->get();
            
        if (!$publisherId) {
            $publishers = Publisher::orderBy('name', 'ASC')->get();
        } else {
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

            $years = [];
            foreach ($yearServices as $y) {

                $arrayReport = [];
                foreach ($arrayMonth as $key => $month) {
                    $monthData = FieldService::where('year_service_id', $y->id)
                        ->where('month', $key)
                        ->where('publisher_id', $p->id)
                        ->first();
                    
                    $arrayReport[] = [
                        'month' => $month,
                        'placements' => (!$monthData) ? null : $monthData->placements,
                        'videos' => (!$monthData) ? null : $monthData->videos,
                        'hours' => (!$monthData) ? null : $monthData->hours,
                        'return_visits' => (!$monthData) ? null : $monthData->return_visits,
                        'studies' => (!$monthData) ? null : $monthData->studies,
                        'observations' => (!$monthData) ? null : $monthData->observations,
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
                'pioneer_code' => $p->pioneer_code,
                'privilege' => $p->privilege,

                // @todo
                'address' => null,
                'landline' => null,
                'msisdn' => null,

                'year_services' => $years
            ];
        }

        return $arrayCard;
    }

    public function ajaxData() 
    {
        $builder = Publisher::orderBy('name', 'ASC');

        $dt = new Datatables();
        return $dt->eloquent($builder)

            ->addColumn('group', function($item) {
                return $item->group()->first()->name;
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

    public function generate(Request $request, $publisherId = null)
    {
        $fieldData = $this->getReport($publisherId);

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=publisher_card.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        // $columns = array(
        //     'Publicações',
        //     'Vídeos mostrados',
        //     'Horas',
        //     'Revisitas',
        //     'Estudos bíblicos',
        //     'Observações'
        // );

        $callback = function() use ($fieldData)
        {
            $file = fopen('php://output', 'w');

            foreach ($fieldData as $fd) {
                fputcsv($file, array(
                    'Nome:',
                    $fd['name'],
                ));
        
                fputcsv($file, array(
                    'Data de nascimento:',
                    $fd['birthdate'],
                    '',
                    '',
                    '[ '.($fd['gender'] == 'M' ? 'x' : '').' ] Masculino',
                    '[ '.($fd['gender'] == 'F' ? 'x' : '').' ] Feminino',
                ));
        
                fputcsv($file, array(
                    'Data de batismo:',
                    $fd['baptize'],
                    '',
                    '',
                    '[ '.(!$fd['anointed'] ? 'x' : '').' ] Outras ovelhas',
                    '[ '.($fd['anointed'] ? 'x' : '').' ] Ungido',
                ));

                fputcsv($file, array(
                    '',
                    '',
                    '',
                    '',
                    '[ '.($fd['privilege'] == 'OM' ? 'x' : '').' ] Ancião',
                    '[ '.($fd['privilege'] == 'MS' ? 'x' : '').' ] Servo Ministerial',
                    '[ ' .($fd['pioneer_code'] ? 'x' : ''). ' ] Pioneiro regular',
                ));


                $group_name = '';
                foreach($fd['year_services'] as $item) {
                    fputcsv($file, array(
                        "Ano de serviço\n".$item['period'],
                        'Publicações',
                        'Vídeos mostrados',
                        'Horas',
                        'Revisitas',
                        'Estudos bíblicos',
                        'Observações'
                    ));

                    foreach ($item['report'] as $m) {
                        fputcsv($file, array(
                            $m['month'],
                            $m['placements'],
                            $m['videos'],
                            $m['hours'],
                            $m['return_visits'],
                            $m['studies'],
                            $m['observations'],
                        ));
                    }

                    fputcsv($file, array(
                        'Total:',
                    ));
                    
                    fputcsv($file, array(
                        'Média:',
                    ));

                    fputcsv($file, array(
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                    ));

                    fputcsv($file, array(
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                    ));
                }
            }
            
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
        
    }

    public function generateBkp(Request $request, $publisherId = null)
    {
        $fieldData = $this->getReport($publisherId);

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=publisher_card.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columns = array(
            'Mês',
            'Publicações',
            'Vídeos mostrados',
            'Horas',
            'Revisitas',
            'Estudos bíblicos',
            'Observações'
        );

        $callback = function() use ($fieldData, $columns)
        {
            $file = fopen('php://output', 'w');

            foreach ($fieldData as $fd) {
                fputcsv($file, array(
                    'Nome:',
                    $fd['name'],
                    'Grupo:',
                    $fd['group']
                ));
    
                fputcsv($file, array(
                    'Endereço:',
                    $fd['address'],
                ));
    
                fputcsv($file, array(
                    'Telefone residencial:',
                    $fd['landline'],
                    'Telefone celular:',
                    $fd['msisdn'],
                ));
    
                fputcsv($file, array(
                    'Data de nascimento:',
                    $fd['birthdate'],
                    'Data da imersão:',
                    $fd['baptize'],
                ));
        
                $group_name = '';
                foreach($fd['year_services'] as $item) {
                    fputcsv($file, array(
                        'Ano de Serviço:',
                        $item['period']
                    ));

                    fputcsv($file, $columns);

                    foreach ($item['report'] as $m) {
                        fputcsv($file, array(
                            $m['month'],
                            $m['placements'],
                            $m['videos'],
                            $m['hours'],
                            $m['return_visits'],
                            $m['studies'],
                            $m['observations'],
                        ));
                    }
                    
                }
            }
            
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
        
    }
}