<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Traits\DateTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class MeetingController extends Controller
{
    use DateTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('meeting/index');
    }

    public function ajaxData() 
    {

        $builder = Meeting::whereRaw('1=1')->orderBy('date', 'desc');

        $dt = new Datatables();
        return $dt->eloquent($builder)

            ->addColumn('date', function($item) {
                return ($item->date) ? date('d/m/Y', strtotime($item->date)) : "";
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
        $title = "Novo Assistência as Reuniões";
        $meeting = new Meeting();
        $action = '/meeting/new';

        if($id != null) {
            $action = '/meeting/edit';
            $title = "Editar Assistência as Reuniões";
            $meeting = Meeting::where('id', '=', $id)
                ->first();
        }

        return view('meeting/edit', [
            'action' => $action,
            'title' => $title,
            'meeting' => $meeting,
            'disabled' => false
        ]);
    }

    private function save(Request $req, $status = "0")
    {
        try {
            $meeting = new Meeting();

            if($req->id) {
                $meeting = Meeting::where('id','=',$req->id)->first();
            }

            $meeting->date = $this->convertString2Carbon($req->date);
            $meeting->attendance = $req->attendance;
            $meeting->observations = $req->observations;

            $meeting->save();

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
        return redirect('/meeting/list')
            ->with('status', 'Assistência as reuniões cadastrada com sucesso.');
    }

    public function update(Request $req) {
        $this->save($req);
        $url = $req->redirects_to;
        return redirect()->to($url)
            ->with('status', 'Assistência as reuniões atualizada com sucesso.');
    }
}