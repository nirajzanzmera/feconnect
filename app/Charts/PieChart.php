<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Highcharts\Chart;

class PieChart extends Chart
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
        $this->dataset('', 'pie', array_values($values))->options([
            'allowPointSelect' =>  true,
            'color' => ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
            'dataLabels' => [
                'format' => '<b>{point.name} {point.y:,.0f}</b><br>{point.percentage:.1f} %',
            ]
        ]);
    }
}
