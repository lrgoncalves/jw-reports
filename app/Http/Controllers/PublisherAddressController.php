<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use App\Models\PublisherAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class PublisherAddressController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit(Request $req, $id = null)
    {
        $action = 'nova';
        $title = "Cadastrar Endereço";
        $publisherAddress = new PublisherAddress();
        $action = '/publisher_address/new';

        if ($req->has('pbid')) {
            $id = $req->get('pbid');
        }

        if($id != null) {
            $title = "Editar Endereço";
            $publisherAddress = PublisherAddress::where('publisher_id', '=', $id)
                ->first();

            if (!$publisherAddress) {
                $publisherAddress = new PublisherAddress();
            }
        }

        return view('publisher_address/edit', [
            'action' => $action,
            'title' => $title,
            'publisherAddress' => $publisherAddress,
            'householders' => Publisher::whereNull('householder_id')->get(),
            'disabled' => false,
            'pbid' => ($req->has('pbid')) ? $req->get('pbid') : null,
        ]);
    }

    private function save(Request $req)
    {
        try {
            $publisherAddress = new PublisherAddress();

            if($req->id) {
                $publisherAddress = PublisherAddress::where('id','=',$req->id)->first();
            }

            $publisherAddress->publisher_id = $req->publisher_id;
            $publisherAddress->address = $req->address;
            $publisherAddress->address_2 = $req->address_2;
            $publisherAddress->number = $req->number;
            $publisherAddress->neighborhood = $req->neighborhood;
            $publisherAddress->city = $req->city;
            $publisherAddress->state = $req->state;
            $publisherAddress->zipcode = $req->zipcode;
            $publisherAddress->save();

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
        $url = $req->redirects_to;

        return redirect()->to($url)
            ->with('status', 'Endereço cadastrado com sucesso.');
    }
}