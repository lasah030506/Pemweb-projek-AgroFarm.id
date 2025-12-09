<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCommodities = \App\Models\Commodity::count();
        $totalHistory = \App\Models\PriceHistory::count();
        
        return view('dashboard.index', compact('totalCommodities', 'totalHistory'));
    }
}
