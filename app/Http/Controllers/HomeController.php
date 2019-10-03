<?php

namespace App\Http\Controllers;

use App\Models\FieldService;
use App\Models\Publisher;
use App\Models\PublisherServiceType;
use App\Models\YearService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalPublishers = Publisher::all()->count();
        $totalPioneers = PublisherServiceType::where('service_type_id', 4)->get()->count();

        $lastMonth = date('m') - 1;
        $dt =  sprintf('%s-%s-%s', date('Y'), str_pad($lastMonth, 2, '0', STR_PAD_LEFT), '01');
        $yearService = YearService::
                    whereRaw('"'.$dt.'" >= start_at')
                    ->whereRaw('"'.$dt.'" <= finish_at')
                    ->first();
        $totalReports = FieldService::where('year_service_id', $yearService->id)
            ->where('month', $lastMonth)
            ->get()->count();
            
        $sixMonthAgo = date('m') - 7;
        $dt =  sprintf('%s-%s-%s', date('Y'), str_pad($sixMonthAgo, 2, '0', STR_PAD_LEFT), '01');

        $totalNonBaptizedPublishers = Publisher::whereNull('baptize_date')->count();


        return view('home', compact('totalPublishers', 'totalPioneers', 'totalReports', 'totalNonBaptizedPublishers'));
    }
}
