<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Charts\DashboardChart;

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

        $chart = new DashboardChart();
        
        return view('home', [
            'chart' => $chart,
        ]);
    }

    public function show() {
        
    }
}
