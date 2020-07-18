<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Charts\BarChart;
use App\Charts\PieChart;
use App\Ticket;

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
        //$barChart = new BarChart;
        //dd($barChart);
        //$barChart->labels(['one', 'two', 'three']);
        //$pieChart = new PieChart;
        //dd($pieChart);
        
        return view('home', [
            //'barChart' => $barChart,
            //'pieChart' -> $pieChart,
        ]);
    }

    public function show() {
        
    }
}
