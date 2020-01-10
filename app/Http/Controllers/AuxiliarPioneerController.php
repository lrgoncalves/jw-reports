<?php

namespace App\Http\Controllers;

use App\Models\PublisherServiceType;
use App\Models\Publisher;
use App\Models\ServiceType;
use App\Traits\DateTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class AuxiliarPioneerController extends PioneerController
{
    use DateTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('pioneer/index', [
            'ajaxDataRoute' => route('auxiliar_pioneer.ajaxData')
        ]);
    }

    public function ajaxData() 
    {
        $builder = PublisherServiceType::whereIn('service_type_id', [2, 3])
            ->orderBy('finish_at', 'ASC')
            ->orderBy('start_at', 'ASC');

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
                $html .= '<a class="btn btn-social-icon" data-toggle="tooltip" title="Editar" href="'.route('pioneer.edit', $item->id).'">
                    <i class="fa fa-pencil text-blue"></i>
                </a>';
                return $html;
            })

            ->rawColumns([
                'action'
            ])
            ->make();
    }

}