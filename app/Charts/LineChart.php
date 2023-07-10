<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Highcharts\Chart;

class LineChart extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct($title, $values)
    {
        parent::__construct();

        $this->title($title);
        $this->labels(array_keys($values));
        $this->dataset($title, 'line', array_values($values))->options([
            'color' => '#058DC7',
           
        ]);
    }
}
