<?php

namespace App\Http\Controllers;

use App\Models\FieldService;
use App\Models\Publisher;
use App\Traits\DateTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class FieldServiceController extends Controller
{
    use DateTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ajaxData() 
    {

        $builder = FieldService::whereRaw('1=1');

        $dt = new Datatables();
        return $dt->eloquent($builder)
            ->addColumn('action', function($item) {
                $html = "";
                $html .= '<a class="btn btn-social-icon" data-toggle="tooltip" title="Editar" onclick="javascript: window.location=\'edit/'.$item->id.'\'">
                    <i class="fa fa-pencil text-blue"></i>
                </a>';

                $html .= '<a class="btn btn-social-icon" data-toggle="tooltip" title="Remover" onclick="javascript: remover('.$item->id.')">
                    <i class="fa fa-remove text-red"></i>
                </a>';

                
                return $html;
            })
            ->addColumn('date', function($item) {
                return ($item->date->format('m/Y'));
            })
            ->addColumn('publisher_name', function($item) {
                return ($item->publisher()->first()->name);
            })
            ->rawColumns([
                'hours', 'placements', 'videos', 'return_visits', 'studies', 'action'
            ])
            ->make();
    }

    public function index()
    {
        return view('field_service/index');
    }

    public function edit(Request $req, $id = null)
    {
        $defaultMonth = sprintf('%s/%s', str_pad(date('m') - 1, 2, '0', STR_PAD_LEFT), date('Y'));

        if (!$id and ($req->has('pbid'))) {
            $defaultDate = $this->convertStringMY2Carbon($defaultMonth);
            $fieldService = FieldService::where('publisher_id', $req->get('pbid'))
                ->where('date', $defaultDate->format('Y-m-d'))
                ->first();
            if ($fieldService)
                $id = $fieldService->id;
        }

        $action = 'nova';
        $title = "Novo Lançamento";
        $fieldService = new FieldService();
        $action = '/field_service/new';

        if($id != null) {
            $action = '/field_service/edit';
            $title = "Editar Lançamento";
            $fieldService = FieldService::where('id', '=', $id)
                ->first();
        }


        return view('field_service/edit', [
            'action' => $action,
            'title' => $title,
            'fieldService' => $fieldService,
            'defaultMonth' => $defaultMonth,
            'publishers' => Publisher::all(),
            'disabled' => false,
            'pbid' => ($req->has('pbid')) ? $req->get('pbid') : null,
        ]);
    }

    private function save(Request $req, $status = "0")
    {
        try {
            $fieldService = new FieldService();

            if($req->id) {
                $fieldService = FieldService::where('id','=',$req->id)->first();
            }

            $fieldService->publisher_id = $req->publisher_id;
            $fieldService->date = $this->convertStringMY2Carbon($req->date);
            $fieldService->hours = $req->hours;
            $fieldService->placements = $req->placements;
            $fieldService->videos = $req->videos;
            $fieldService->return_visits = $req->return_visits;
            $fieldService->studies = $req->studies;

            $fieldService->save();

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
        return redirect('/field_service/list')
            ->with('status', 'Publicador cadastrado com sucesso.');
    }

    public function update(Request $req) {
        $this->save($req);
        return redirect('/field_service/list')
            ->with('status', 'Publicador atualizado com sucesso.');
    }

    public function delete(Request $req, $id)
    {
        $fieldService = FieldService::where('id', '=', $id)
            ->first();
        $fieldService->forceDelete();
        return redirect('/field_service/list')
            ->with('status', 'Publicador removido.');

    }
}