<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\FieldService;
use App\Models\Publisher;
use App\Models\PublisherAddress;
use App\Models\YearService;
use App\Traits\DateTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class PublisherController extends Controller
{
    use DateTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ajaxData(Request $request) 
    {
        $builder = Publisher::whereRaw('1=1')->orderBy('name', 'asc');

        if ($request->has('filter')) {
            switch ($request->get('filter')) {
                case 'nonBaptized':
                    $builder->whereNull('baptize_date');
                break;
                case 'elderly':
                    $builder->where('privilege', 'OM');
                break;
                case 'ministerialServants':
                    $builder->where('privilege', 'MS');
                break;
                case 'irregulars':
                    $irregulars = DB::select("SELECT DISTINCT publisher_id FROM field_services
                        WHERE hours IS NULL
                        AND date_ref >= DATE_SUB(CURDATE(), INTERVAL 5 MONTH)");
                    $ids = [];
                    foreach ($irregulars as $i) {
                        $ids[] = $i->publisher_id;
                    }
                    
                    $builder->whereIn('id', $ids);
                break;
                case 'inactives':
                    $inactives = DB::select("SELECT p.id, sum(fs.hours) as total_hours 
                        FROM publishers p
                        LEFT JOIN (
                            SELECT publisher_id, hours FROM field_services WHERE date_ref >= (DATE_SUB(curdate(), INTERVAL 7 MONTH))
                        ) AS fs ON fs.publisher_id = p.id
                        WHERE p.baptize_date IS NOT NULL
                        GROUP BY 1
                        HAVING SUM(fs.hours) IS NULL");
                    $ids = [];
                    foreach ($inactives as $i) {
                        $ids[] = $i->id;
                    }
                    $builder->whereIn('id', $ids);
                break;

                default:
                    if (substr($request->get('filter'), 0, 5) == 'group') {
                        $groupId = substr($request->get('filter'), 6);
                        $builder->where('group_id', $groupId);
                    }
                break;
            }
        }

        $dt = new Datatables();
        return $dt->eloquent($builder)
            ->addColumn('action', function($item) {
                $html = "";
                $html .= '<a class="btn btn-social-icon" data-toggle="tooltip" title="Editar" onclick="javascript: window.location=\'edit/'.$item->id.'\'">
                    <i class="fa fa-pencil text-blue"></i>
                </a>';

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
                    
                $fieldServiceAv = FieldService::where('publisher_id', $item->id)
                    ->where('month', $lastMonth)
                    ->where('year_service_id', $yearService->id)
                    ->first();
                
                $color = 'text-green';
                if (!$fieldServiceAv) {
                    if (date('d') < 10) {
                        $color = 'text-yellow';
                    } else if (date('d') < 15) {
                        $color = 'text-orange';
                    } else {
                        $color = 'text-red';
                    }
                }

                $html .= '<a class="btn btn-social-icon" data-toggle="tooltip" title="Lançar relatório" onclick="javascript: lancar('.$item->id.');">
                    <i class="fa fa-clock-o '.$color.' "></i>
                </a>';

                $html .= '<a class="btn btn-social-icon" data-toggle="tooltip" title="Cartão do publicador (S-21-T 12/18)" onclick="javascript: printCard('.$item->id.');">
                    <i class="fa fa-file-pdf-o text-blue "></i>
                </a>';

                // $html .= '<a class="btn btn-social-icon" data-toggle="tooltip" title="Remover" onclick="javascript: remover('.$item->id.')">
                //     <i class="fa fa-remove text-red"></i>
                // </a>';

                if (is_null($item->householder_id)) {

                    $publisherAddress = PublisherAddress::where('publisher_id', $item->id)->first();
                    $color = ($publisherAddress) ? 'black' : 'red';

                    $html .= '<a class="btn btn-social-icon" data-toggle="tooltip" title="Endereço" onclick="javascript: endereco('.$item->id.');">
                        <i class="fa fa-home text-'.$color.'"></i>
                    </a>';
                }
                
                return $html;
            })
            ->addColumn('group', function($item){
                return $item->group()->first()->name;
            })
            ->addColumn('baptize_date', function($item) {
                return ($item->baptize_date) ? date('d/m/Y', strtotime($item->baptize_date)) : "";
            })
            ->rawColumns([
                'name', 'phone_numbers', 'action'
            ])
            ->make();
    }

    public function index(Request $request)
    {
        // dd($request->has('nonBaptized'));
        $filter = null;
        $filterName = null;
        if ($request->has('nonBaptized')) {
            $filter = 'nonBaptized';
            $filterName = 'Não Batizados';
        }

        if ($request->has('irregulars')) {
            $filter = 'irregulars';
            $filterName = 'Irregulares';
        }

        if ($request->has('inactives')) {
            $filter = 'inactives';
            $filterName = 'Inativos';
        }

        if ($request->has('elderly')) {
            $filter = 'elderly';
            $filterName = 'Anciãos';
        }

        if ($request->has('ministerialServants')) {
            $filter = 'ministerialServants';
            $filterName = 'Servos Ministeriais';
        }

        if ($request->has('group')) {
            $filter = 'group:'.$request->get('group');
            $filterName = sprintf('Grupo %s', Group::whereId($request->get('group'))->first()->name);
        }


        return view('publisher/index', compact('filter', 'filterName') );
    }

    public function edit($id = null)
    {
        $action = 'nova';
        $title = "Nova Publicador";
        $publisher = new Publisher();
        $action = '/publisher/new';

        if($id != null) {
            $action = '/publisher/edit';
            $title = "Editar Publicador";
            $publisher = Publisher::where('id', '=', $id)
                ->first();
        }

        return view('publisher/edit', [
            'action' => $action,
            'title' => $title,
            'publisher' => $publisher,
            'householders' => Publisher::whereNull('householder_id')->get(),
            'groups' => Group::all(),
            'disabled' => false
        ]);
    }

    private function save(Request $req, $status = "0")
    {
        try {
            $publisher = new Publisher();

            if($req->id) {
                $publisher = Publisher::where('id','=',$req->id)->first();
            }

            $publisher->householder_id = $req->householder_id;
            $publisher->name = $req->name;
            $publisher->gender = $req->gender;
            $publisher->birthdate = $this->convertString2Carbon($req->birthdate);
            $publisher->baptize_date = $this->convertString2Carbon($req->baptize_date);
            $publisher->phone_numbers = $req->phone_numbers;
            $publisher->anointed = $req->anointed;
            $publisher->privilege = $req->privilege;
            $publisher->pioneer_code = $req->pioneer_code;
            $publisher->group_id = $req->group_id;

            $publisher->save();

            return true;
        } catch (Illuminate\Database\QueryException $e) {
            dd($e);
            return false;
        } catch (PDOException $e) {
            dd($e);
            return false;
        }
    }

    public function new(Request $req) {
        $this->save($req);
        return redirect('/publisher/list')
            ->with('status', 'Publicador cadastrado com sucesso.');
    }

    public function update(Request $req) {
        $this->save($req);
        return redirect('/publisher/list')
            ->with('status', 'Publicador atualizado com sucesso.');
    }

    public function delete(Request $req, $id)
    {
        $publisher = Publisher::where('id', '=', $id)
            ->first();
        $publisher->forceDelete();
        return redirect('/publisher/list')
            ->with('status', 'Publicador removido.');

    }
}