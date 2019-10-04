<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class GroupMemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ajaxData() 
    {
        $builder = GroupMember::whereRaw('1=1');

        $dt = new Datatables();
        return $dt->eloquent($builder)

            ->addColumn('group', function($item) {
                return $item->group()->first()->name;
            })

            ->addColumn('householder', function($item) {
                return $item->householder()->first()->name;
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
        return view('group_member/index');
    }

    public function edit($id = null)
    {
        $action = 'novo';
        $title = "Novo Membros de Grupo";
        $group = new GroupMember();
        $action = '/group_member/new';

        if($id != null) {
            $action = '/group_member/edit';
            $title = "Editar Membros de Grupo";
            $group = GroupMember::where('id', '=', $id)
                ->first();
        }

        return view('group_member/edit', [
            'action' => $action,
            'title' => $title,
            'group' => $group,
            'disabled' => false,
            'publishers' => Publisher::whereNull('householder_id')->get(),
            'groups' => Group::all(),
        ]);
    }

    private function save(Request $req, $status = "0")
    {
        try {
            $group = new GroupMember();

            if($req->id) {
                $group = GroupMember::where('id','=',$req->id)->first();
            }

            $group->group_id = $req->group_id;
            $group->householder_id = $req->householder_id;

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
        return redirect('/group_member/list')
            ->with('status', 'Grupo cadastrada com sucesso.');
    }

    public function update(Request $req) {
        $this->save($req);
        $url = $req->redirects_to;
        return redirect()->to($url)
            ->with('status', 'Grupo atualizada com sucesso.');
    }
}