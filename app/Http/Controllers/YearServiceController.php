<?php

namespace App\Http\Controllers;

use App\Models\YearService;
use App\Traits\DateTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class YearServiceController extends Controller
{
    use DateTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ajaxData() 
    {

        $builder = YearService::whereRaw('1=1');

        $dt = new Datatables();
        return $dt->eloquent($builder)

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

    public function index()
    {
        return view('year_service/index');
    }

    public function edit($id = null)
    {
        $action = 'novo';
        $title = "Novo Ano de Serviço";
        $yearService = new YearService();
        $action = '/year_service/new';

        if($id != null) {
            $action = '/year_service/edit';
            $title = "Editar Ano de Serviço";
            $yearService = YearService::where('id', '=', $id)
                ->first();
        }

        return view('year_service/edit', [
            'action' => $action,
            'title' => $title,
            'yearService' => $yearService,
            'disabled' => false
        ]);
    }

    private function save(Request $req, $status = "0")
    {
        try {
            $yearService = new YearService();

            if($req->id) {
                $yearService = YearService::where('id','=',$req->id)->first();
            }

            $yearService->start_at = $this->convertString2Carbon($req->start_at);
            $yearService->finish_at = $this->convertString2Carbon($req->finish_at);

            $yearService->save();

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
        return redirect('/year_service/list')
            ->with('status', 'Ano de Serviço cadastrada com sucesso.');
    }

    public function update(Request $req) {
        $this->save($req);
        $url = $req->redirects_to;
        return redirect()->to($url)
            ->with('status', 'Ano de Serviço atualizada com sucesso.');
    }
}