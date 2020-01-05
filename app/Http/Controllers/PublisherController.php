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

    public function ajaxData() 
    {

        $builder = Publisher::whereRaw('1=1')->orderBy('name', 'asc');

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

                $html .= '<a class="btn btn-social-icon" data-toggle="tooltip" title="Cartão do publicador" onclick="javascript: printCard('.$item->id.');">
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
            ->addColumn('baptize_date', function($item) {
                return ($item->baptize_date) ? date('d/m/Y', strtotime($item->baptize_date)) : "";
            })
            ->rawColumns([
                'name', 'action'
            ])
            ->make();
    }

    public function index()
    {
        return view('publisher/index');
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

            // dd($publisher, date('d/m/Y', strtotime($publisher->baptize_date)));
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