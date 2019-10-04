<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ajaxData() 
    {
        $builder = Group::whereRaw('1=1');

        $dt = new Datatables();
        return $dt->eloquent($builder)

            ->addColumn('overseer', function($item) {
                return $item->overseer()->first()->name;
            })

            ->addColumn('assistant', function($item) {
                return $item->assistant()->first()->name;
            })

            ->addColumn('action', function($item) {
                $html = "";
                $html .= '<a class="btn btn-social-icon" data-toggle="tooltip" title="Editar" onclick="javascript: window.location=\'edit/'.$item->id.'\'">
                    <i class="fa fa-pencil text-blue"></i>
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
        return view('group/index');
    }

    public function edit($id = null)
    {
        $action = 'novo';
        $title = "Novo Grupo";
        $group = new Group();
        $action = '/group/new';

        if($id != null) {
            $action = '/group/edit';
            $title = "Editar Grupo";
            $group = Group::where('id', '=', $id)
                ->first();
        }

        return view('group/edit', [
            'action' => $action,
            'title' => $title,
            'group' => $group,
            'disabled' => false,
            'publishers' => Publisher::whereNull('householder_id')->get(),
        ]);
    }

    private function save(Request $req, $status = "0")
    {
        try {
            $group = new Group();

            if($req->id) {
                $group = Group::where('id','=',$req->id)->first();
            }

            $group->name = $req->name;
            $group->overseer_id = $req->overseer_id;
            $group->assistant_id = $req->assistant_id;

            $group->save();

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
        return redirect('/group/list')
            ->with('status', 'Grupo cadastrada com sucesso.');
    }

    public function update(Request $req) {
        $this->save($req);
        $url = $req->redirects_to;
        return redirect()->to($url)
            ->with('status', 'Grupo atualizada com sucesso.');
    }
}