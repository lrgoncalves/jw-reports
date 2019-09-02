<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;

use App\Models\Congregation;
use App\Models\Publisher;

class CongregationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ajaxData() {

        $builder = Congregation::whereRaw('1=1');

        $dt = new Datatables();
        return $dt->eloquent($builder)
            // ->addColumn('logoImage', function($item) {
            //     $html = '<img src="'.$item->logo.'" style="width: 50px;" />';
            //     return $html;
            // })
            ->addColumn('action', function($item) {
                $contacts = $item->publishers()->get();
                $html = "0";
                if($contacts->count() > 0) {
                    $html = '<span class="label label-success">'.$contacts->count().'</span>';
                }
                // $html = '';
                // $html .= '<a class="btn btn-social-icon" data-toggle="tooltip" title="Contatos" onclick="javascript: window.location=\'contacts/'.$item->id.'\'">
                //     <i class="fa fa-address-book text-yellow"></i>
                //     '.$qtdContacts.'
                // </a>';
                
                return $html;
            })
            ->rawColumns([
                'code', 'name'
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
            $title = "Editar parceiro";
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
            ->with('status', 'Parceiro cadastrado com sucesso.');
    }

    public function update(Request $req) {
        $this->save($req);
        $url = $req->redirects_to;
        return redirect()->to($url)
            ->with('status', 'Parceiro atualizado com sucesso.');
    }
}