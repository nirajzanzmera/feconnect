<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Highcharts\Chart;

class BarChart extends Chart
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
        $this->dataset($title, 'bar', array_values($values))->options([
            'color' => '#058DC7',
           /* 'dataLabels' => [
                'format' => '<b>{point.name} {point.y:,.0f}</b><br>{point.percentage:.1f} %',
            ]*/
        ]);
    }
}
