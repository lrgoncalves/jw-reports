<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use App\Models\PublisherUnhealthy;
use App\Traits\DateTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class PublisherUnhealthyController extends Controller
{
    use DateTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ajaxData() 
    {
        $builder = PublisherUnhealthy::whereRaw('1=1');

        $dt = new Datatables();
        return $dt->eloquent($builder)

            ->addColumn('publisher_name', function($item) {
                return $item->publisher()->first()->name;
            })

            ->addColumn('start_at', function($item) {
                return ($item->start_at) ? date('d/m/Y', strtotime($item->start_at)) : "";
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
        return view('publisher_unhealthy/index');
    }

    public function edit($id = null)
    {
        $action = 'novo';
        $title = "Novo Publicador limitado";
        $group = new PublisherUnhealthy();
        $action = '/publisher_unhealthy/new';

        if($id != null) {
            $action = '/publisher_unhealthy/edit';
            $title = "Editar Publicador limitado";
            $group = PublisherUnhealthy::where('id', '=', $id)
                ->first();
        }

        return view('publisher_unhealthy/edit', [
            'action' => $action,
            'title' => $title,
            'group' => $group,
            'disabled' => false,
            'publishers' => Publisher::all(),
        ]);
    }

    private function save(Request $req, $status = "0")
    {
        try {
            $publisherUnhealthy = new PublisherUnhealthy();

            if($req->id) {
                $publisherUnhealthy = PublisherUnhealthy::where('id','=',$req->id)->first();
            }

            $publisherUnhealthy->publisher_id = $req->householder_id;
            $publisherUnhealthy->start_at = $this->convertString2Carbon($req->start_at);


            $publisherUnhealthy->save();

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
        return redirect('/publisher_unhealthy/list')
            ->with('status', 'Grupo cadastrada com sucesso.');
    }

    public function update(Request $req) {
        $this->save($req);
        $url = $req->redirects_to;
        return redirect()->to($url)
            ->with('status', 'Grupo atualizada com sucesso.');
    }
}