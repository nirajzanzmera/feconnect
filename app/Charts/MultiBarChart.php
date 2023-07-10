<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Highcharts\Chart;

class MultiBarChart extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct($title, $labels, $values)
    {
        parent::__construct();

        $colors = ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'];

        $this->title($title);
        $this->labels($labels);
        foreach (array_keys($values) as $label) {
            $this->dataset($label, 'bar', $values[$label])->options([
               next($colors)
            ]);
        }
    }
}
