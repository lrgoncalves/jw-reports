<?php

namespace App\Http\Controllers;

use App\Models\Congregation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class CongregationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ajaxData() 
    {

        $builder = Congregation::whereRaw('1=1');

        $dt = new Datatables();
        return $dt->eloquent($builder)
            ->addColumn('total_publishers', function($item) {
                $html = $item->publishers()->count();
                return $html;
            })

            ->addColumn('action', function($item) {
                $html = "";
                $html .= '<a class="btn btn-social-icon" data-toggle="tooltip" title="Editar" onclick="javascript: window.location=\'edit/'.$item->id.'\'">
                    <i class="fa fa-pencil text-blue"></i>
                </a>';
                return $html;
            })

            ->rawColumns([
                'code', 'name', 'action'
            ])
            ->make();
    }

    public function index()
    {
        return view('congregation/index');
    }

    public function edit($id = null)
    {
        $action = 'nova';
        $title = "Nova congregação";
        $congregation = new Congregation();
        $action = '/congregation/new';

        if($id != null) {
            $action = '/congregation/edit';
            $title = "Editar congregação";
            $congregation = Congregation::where('id', '=', $id)
                ->first();
        }

        return view('congregation/edit', [
            'action' => $action,
            'title' => $title,
            'congregation' => $congregation,
            'disabled' => false
        ]);
    }

    private function save(Request $req, $status = "0")
    {
        try {
            $congregation = new Congregation();

            if($req->id) {
                $congregation = Congregation::where('id','=',$req->id)->first();
            }

            $congregation->name = $req->name;
            $congregation->code = $req->code;

            $congregation->save();

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
        return redirect('/congregation/list')
            ->with('status', 'Congregação cadastrada com sucesso.');
    }

    public function update(Request $req) {
        $this->save($req);
        $url = $req->redirects_to;
        return redirect()->to($url)
            ->with('status', 'Congregação atualizada com sucesso.');
    }
}