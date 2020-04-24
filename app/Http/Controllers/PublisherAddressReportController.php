<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use App\Models\PublisherAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Str;
use PDF;

class PublisherAddressReportController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ajaxData() 
    {
        $builder = Publisher::
            whereNull('householder_id')
            ->orderBy('name', 'ASC');

        $dt = new Datatables();
        return $dt->eloquent($builder)

            ->addColumn('group', function($item) {
                return $item->group()->first()->name;
            })

            ->addColumn('action', function($item) {
                $html = "";

                $publisherAddress = PublisherAddress::where('publisher_id', $item->id)->first();
                $color = ($publisherAddress) ? 'black' : 'red';

                $html .= '<a class="btn btn-social-icon" data-toggle="tooltip" title="Endereço" onclick="javascript: endereco('.$item->id.');">
                    <i class="fa fa-home text-'.$color.'"></i>
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
        return view('publisher_address_report/index');
    }

    public function report(Request $request) 
    {
        $publishers = Publisher::
            whereNull('householder_id')
            ->orderBy('name', 'ASC')
            ->get();

        $data = [];
        foreach ($publishers as $p) {

            $address = $p->address()->first();
            
            $addressStr = '';
            if ($address) {
                $addressStr .= $address->address;

                if ($address->address_2) {
                    $addressStr .=', ' . $address->address_2;
                }

                $addressStr .=', ' . $address->number;
                $addressStr .=', ' . $address->neighborhood;
                $addressStr .=' - ' . $address->city;
                $addressStr .=' - ' . $address->state;

                if ($address->zipcode && $address->zipcode != '00000-000') {
                    $addressStr .=' - CEP: ' . $address->zipcode;
                }
            }
            
            $data[] = [
                'name' => $p->name,
                'phones' => $p->phone_numbers,
                'family' => $p->members()->get(),
                'address' => $addressStr,
            ];

        }
        
        // return view('publisher_address_report/report', ['data' => $data]);
        $pdf = PDF::loadView('publisher_address_report/report', ['data' => $data])
            ->setPaper('a4', 'portrait'); 
        return $pdf->download(sprintf('%s.pdf', Str::slug('publishers_addresses')));

    }
}