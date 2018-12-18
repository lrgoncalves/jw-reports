<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerCategoryTrend;
use Illuminate\Http\Request;

class CustomerCategoryTrendController extends Controller
{
    public function categoryTrends(Request $request, $msisdn)
    {
        $customer = Customer::where('msisdn', '=', $msisdn)->first();
        if (!$customer) {
            return response()->json([], 404);
        }

        return CustomerCategoryTrend::where('customer_id', '=', $customer->id)
            ->with('category')
            ->with('product')
            ->get();

    }
}
