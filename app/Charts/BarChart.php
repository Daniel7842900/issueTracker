<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use App\Ticket;

class BarChart extends BaseChart
{

    /**
     * Determines the chart name to be used on the
     * route. If null, the name will be a snake_case
     * version of the class name.
     */
    public ?string $name = 'bar_chart';

    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {

        $tickets = Ticket::all();
        //dd($tickets);
        $lowCount = 0;
        $mediumCount = 0;
        $highCount = 0;
        for($i = 0; $i < count($tickets); $i++) {
            if($tickets[$i]->priority == 'low') {
                $lowCount++;
            } else if($tickets[$i]->priority == 'medium') {
                $mediumCount++;
            } else if($tickets[$i]->priority == 'high') {
                $highCount++;
            }
        }

        $chart = Chartisan::build()
                ->labels(['Low', 'Medium', 'High'])
                ->dataset('Priority', [$lowCount, $mediumCount, $highCount]);
        
        return $chart;
    }
}