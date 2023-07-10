<?php

namespace App\Charts;

use App\Charts\BaseChart;


class MultiLineChart extends BaseChart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct($labels, $values, $title = '')
    {
        parent::__construct();
        $this->title($title);
        if(!empty($labels)) {
            $this->labels($labels);
        }
        if (is_array($values)) {
            foreach (array_keys($values) as $label) {
                $this->dataset($label, 'line', array_values($values[$label]))->options([
                    next($this->colors)
                ]);
            }
        }
    }
}
