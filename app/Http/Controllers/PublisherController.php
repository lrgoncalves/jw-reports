<?php

namespace App\Http\Controllers;

use App\Models\Congregation;
use App\Models\Publisher;
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

        $builder = Publisher::whereRaw('1=1');

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
            ->addColumn('baptize_date', function($item) {
                return date('d/m/Y', strtotime($item->baptize_date));
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
        }

        return view('publisher/edit', [
            'action' => $action,
            'title' => $title,
            'publisher' => $publisher,
            'congregations' => Congregation::all(),
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

            $publisher->congregation_id = $req->congregation_id;
            $publisher->name = $req->name;
            $publisher->birth_date = $this->convertString2Carbon($req->birth_date);
            $publisher->baptize_date = $this->convertString2Carbon($req->baptize_date);

            $publisher->pioneer_code = $req->pioneer_code;

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