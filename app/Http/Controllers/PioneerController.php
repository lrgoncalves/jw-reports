<?php

namespace App\Http\Controllers;

use App\Models\PublisherServiceType;
use App\Models\Publisher;
use App\Models\ServiceType;
use App\Traits\DateTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class PioneerController extends Controller
{
    use DateTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('pioneer/index');
    }

    public function ajaxData() 
    {

        $builder = PublisherServiceType::whereNull('finish_at');

        $dt = new Datatables();
        return $dt->eloquent($builder)

            ->addColumn('publisher_name', function($item) {
                return $item->publisher()->first()->name;
            })

            ->addColumn('service_type', function($item) {
                return $item->serviceType()->first()->name;
            })

            ->addColumn('start_at', function($item) {
                return ($item->start_at) ? date('d/m/Y', strtotime($item->start_at)) : "";
            })

            ->addColumn('finish_at', function($item) {
                return ($item->finish_at) ? date('d/m/Y', strtotime($item->finish_at)) : "";
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

    public function edit($id = null)
    {
        $action = 'novo';
        $title = "Novo Pioneiro";
        $pioneer = new PublisherServiceType();
        $action = '/pioneer/new';

        if($id != null) {
            $action = '/pioneer/edit';
            $title = "Editar Pioneiro";
            $pioneer = PublisherServiceType::where('id', '=', $id)
                ->first();
        }

        return view('pioneer/edit', [
            'action' => $action,
            'title' => $title,
            'pioneer' => $pioneer,
            'disabled' => false,
            'publishers' => Publisher::all(),
            'serviceTypes' => ServiceType::whereRaw('name != "Publicador"')->get(),

        ]);
    }

    private function save(Request $req, $status = "0")
    {
        try {
            $pioneer = new PublisherServiceType();

            if($req->id) {
                $pioneer = PublisherServiceType::where('id','=',$req->id)->first();
            }

            $pioneer->publisher_id = $req->publisher_id;
            $pioneer->service_type_id = $req->service_type_id;
            $pioneer->start_at = $this->convertString2Carbon($req->start_at);
            $pioneer->finish_at = $this->convertString2Carbon($req->finish_at);

            $pioneer->save();

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
        return redirect('/pioneer/list')
            ->with('status', 'Pioneiro cadastrada com sucesso.');
    }

    public function update(Request $req) {
        $this->save($req);
        $url = $req->redirects_to;
        return redirect()->to($url)
            ->with('status', 'Pioneiro atualizada com sucesso.');
    }

}