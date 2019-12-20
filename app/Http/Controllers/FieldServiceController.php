<?php

namespace App\Http\Controllers;

use App\Models\FieldService;
use App\Models\Publisher;
use App\Models\YearService;
use App\Models\ServiceType;
use App\Models\PublisherServiceType;
use App\Traits\DateTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class FieldServiceController extends Controller
{
    use DateTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ajaxData(Request $req) {
        
        $data = [];
        if ($req->has('pbid')) {
            $fieldService = FieldService::
                where('publisher_id', $req->input('pbid'))
                ->orderBy('year_service_id', 'Desc')
                ->orderBy('month', 'Desc')
                ->get();
            
            foreach ($fieldService as $fs) {
                $data[] = [
                    'id' => $fs->id,
                    'name' => $fs->publisher()->first()->name,
                    'year' => $fs->yearService()->first()->start_at->format('Y') . '/' . $fs->yearService()->first()->finish_at->format('Y'),
                    'month' => $fs->month,
                    'hours' => $fs->hours,
                    'placements' => $fs->placements,
                    'videos' => $fs->videos,
                    'return_visits' => $fs->return_visits,
                    'studies' => $fs->studies,
                ];
            }
        }
        return json_encode($data);
    }

    public function index()
    {
        $hasYearService = YearService::all();
        if (!$hasYearService->count()) {
            return view('year_service/init');
        }

        return view('field_service/index', [
            'publishers' => Publisher::orderBy('name', 'asc')->get(['id', 'name'])
        ]);
    }

    public function edit(Request $req, $id = null)
    {
        $lastMonth = date('m') - 1;

        $dt =  sprintf('%s-%s-%s', date('Y'), str_pad($lastMonth, 2, '0', STR_PAD_LEFT), '01');

        $yearService = YearService::
                    whereRaw('"'.$dt.'" >= start_at')
                    ->whereRaw('"'.$dt.'" <= finish_at')
                    ->first();

        $fieldService = null;
        $publisherServiceTypeId = null;
        if (!$id and ($req->has('pbid'))) {
            $fieldService = FieldService::where('publisher_id', $req->pbid)
                ->where('month', $lastMonth)
                ->where('year_service_id', $yearService->id)
                ->first();
            
            $publisherServiceType = PublisherServiceType::where('publisher_id', $req->pbid)
                ->whereRaw('"'.$dt.'" >= start_at')
                ->where(function ($q) use ($dt) {
                    return $q->whereRaw('"'.$dt.'" <= finish_at')->orWhereNull('finish_at');
                })
                ->first();
            if ($publisherServiceType) {
                $publisherServiceTypeId = $publisherServiceType->serviceType()->first()->id;
            }
        } else if ($id) {
            $fieldService = FieldService::where('id', $id)->first();
        }

        if ($fieldService) {
            $action = '/field_service/edit';
            $title = "Editar Lançamento";
        } else {
            $action = 'nova';
            $title = "Novo Lançamento";
            $fieldService = new FieldService();
            $action = '/field_service/new';
        }

        $yearServiceDefaul = YearService::orderBy('start_at', 'DESC')->first();


        return view('field_service/edit', [
            'action' => $action,
            'title' => $title,
            'fieldService' => $fieldService,
            'lastMonth' => $lastMonth,
            'publishers' => Publisher::orderBy('name', 'asc')->get(),
            'yearServices' => YearService::orderBy('id', 'desc')->get(),
            'YearServiceDefault' => $yearServiceDefaul,
            'serviceTypes' => ServiceType::all(),
            'publisherServiceTypeId' => $publisherServiceTypeId,
            'disabled' => false,
            'pbid' => ($req->has('pbid')) ? $req->get('pbid') : null,
        ]);
    }

    private function save(Request $req, $status = "0")
    {
        try {
            $fieldService = new FieldService();

            if($req->id) {
                $fieldService = FieldService::where('id','=',$req->id)->first();
            }

            $fieldService->publisher_id = $req->publisher_id;
            $fieldService->year_service_id = $req->year_service_id;
            $fieldService->service_type_id = $req->service_type_id;
            $fieldService->month = $req->month;
            $fieldService->hours = $req->hours;
            $fieldService->placements = $req->placements;
            $fieldService->videos = $req->videos;
            $fieldService->return_visits = $req->return_visits;
            $fieldService->studies = $req->studies;
            $fieldService->observations = $req->observations;

            $fieldService->save();

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
        // return redirect('/field_service/list')
        //     ->with('status', 'Relatório cadastrado com sucesso.');

        $url = $req->redirects_to;
        return redirect()->to($url)
            ->with('status', 'Relatório cadastrado com sucesso.');
    }

    public function update(Request $req) {
        $this->save($req);
        // return redirect('/field_service/list')
        //     ->with('status', 'Relatório atualizado com sucesso.');

        $url = $req->redirects_to;
        return redirect()->to($url)
            ->with('status', 'Relatório atualizado com sucesso.');
    }

    public function delete(Request $req, $id)
    {
        $fieldService = FieldService::where('id', '=', $id)
            ->first();
        $fieldService->forceDelete();
        return redirect('/field_service/list')
            ->with('status', 'Relatório removido.');

    }
}