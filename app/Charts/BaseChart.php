<?php

namespace App\Charts;

use Carbon\CarbonInterval;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use ConsoleTVs\Charts\Classes\Highcharts\Chart;

class BaseChart extends Chart
{

    public $colors = ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'];
    public $empty = true;

    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function get()
    {
        # code...
    }

    /**
    * Loops through start and end of period and creates label and data array for sparse data
    * @param Carbon $start
    * @param Carbon $end
    * @param  $data format ["2019-02-26" => 6, ...]
    * @return void
    */
    public function processPeriod(Carbon $start, Carbon $end, $data)
    {
        $labels = [];
        $res = [];
        $period = new \DatePeriod($start->copy(), CarbonInterval::day(), $end->copy()->endOfDay());   
        $this->empty = true;

        foreach ($period as $day) {
            $labels[] = $day->format('M-d');
            if (!empty($data[$day->format('Y-m-d')])) {
              $this->empty = false;
              $res[$day->format('M-d')] = $data[$day->format('Y-m-d')];
            }
            else {
              $res[$day->format('M-d')] = 0;
            }
        }
        return ['data'=>$res, 'labels'=>$labels];
    }

    public function getImage()
    {
        if ( count($this->datasets) ) {
            $json = [
                "infile" => $this->getJson( 
                    (object) [
                        'labels' => $this->labels,
                        'data' => $this->datasets[0]->values
                    ]
                ),
                "width" => false,
                "scale" => false,
                "constr" => "Chart",
                "callback" => "",
                "styledMode" => false,
                "type" => "image/png",
                "asyncRendering" => false,
                "async" => true
            ];
            
            $client = new \GuzzleHttp\Client();
            $url = 'https://export.highcharts.com/';

            $res = $client->request('POST', $url, [
                'headers' => [
                    'Accept' => '*/*',
                    'Content-Type' => 'application/json'
                ],
                'json'=> $json,
            ]);
            
            if($res->getStatusCode(200)){
                $disk = Storage::disk('s3pub');
                $contents = @file_get_contents($url . $res->getBody());
                $attempt = 0;
                $maxattempts = 3;
                while ($contents === false && $attempt < $maxattempts) {
                  $attempt++;
                  // reattempt
                  sleep(5*$attempt); //wait 5 seconds
                  $contents = @file_get_contents($url . $res->getBody());
                }
                if($contents === false) {
                  return 'error';
                }
                $filename = 'src/charts/'. md5(json_encode($json)).'.png';
                $put = $disk->put($filename, $contents );
                if ($put === true) {
                    return 'https://s3-us-west-2.amazonaws.com/dataczar-public/' . $filename;
                }
            }
            return 'error';
        } else {
            return 'no data, call build first.';
        }
       
    }

    public function getJson($data)
    {
        return '
        {
            "yAxis": {
                "title": {
                    "text": ""
                },
                "labels": {
                    "style": {
                        "color": "#666666"
                    }
                }
            },
            "xAxis": {
                "categories": [
                    "' . implode('","', $data->labels) . '"
                ],
                "labels": {
                    "style": {
                        "color": "#666666"
                    }
                }
            },
            "legend": {
                "enabled": false
            },
            "series": [
                {
                    "0": "#50B432",
                    "data": [
                        ' . implode(',', $data->data) .'
                    ],
                    "type": "area"
                }
            ],
            "credits": {
                "enabled": false
            },
            "title": {
                "text": ""
            },
            "chart": {
                "backgroundColor": "#FFFFFF",
                "width": 518,
                "height": 172
            }
        }';

    }
}
