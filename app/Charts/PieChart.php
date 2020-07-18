<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use App\Ticket;

class PieChart extends BaseChart
{

    /**
     * Determines the chart name to be used on the
     * route. If null, the name will be a snake_case
     * version of the class name.
     */
    public ?string $name = 'pie_chart';

    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $tickets = Ticket::all();
        //dd($tickets);
        $bugCount = 0;
        $enhancementCount = 0;
        $featureCount = 0;
        for($i = 0; $i < count($tickets); $i++) {
            if($tickets[$i]->type == 'bug') {
                $bugCount++;
            } else if($tickets[$i]->type == 'enhancement') {
                $enhancementCount++;
            } else if($tickets[$i]->type == 'feature') {
                $featureCount++;
            }
        }

        return Chartisan::build()
            ->labels(['Bug/Error', 'Enhancement', 'Feature Request'])
            ->dataset('Type', [$bugCount, $enhancementCount, $featureCount]);

    }
}