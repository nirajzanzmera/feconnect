<?php

namespace App\Images;

use App\Images\ImageService;

class FlatIcon extends ImageService
{
    public function __construct()
    {
        $key = env('FLATICON_KEY');
        if ( !empty($key) ) {
            $url="https://api.flaticon.com/v2/app/authentication";                   
            //$body='{"apikey":"'.$key.'"}';
            $client = new \GuzzleHttp\Client();
            $req = $client->request("POST", $url, [
                'json'=> ['apikey' => $key],
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]);

             //$req->send($req);
            $body = $req->getbody($req);
            $data = $body->read(999999);
            $jd=json_decode($data);
            $this->token = $jd->data->token;
        } else {
            $this->token = [];
        }

    }

    public function searchImages(string $search, $page = 1)
    {
        if (!empty($this->token)) {
            $url="https://api.flaticon.com/v2/search/icons/priority";                   
            $client = new \GuzzleHttp\Client();
            $response = $client->request("GET", $url, [
                    'query'=> [
                        'q' => $search,
                        'limit' => 50,
                        'page' => $page,
                    ],
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => "Bearer ".$this->token,
                    ],
                ]);
            $body = $response->getbody($response);
            $data = $body->read(999999);
            //dd($data);
            $photos = json_decode($data,true);
            return $this->results( $photos );
        } else {
            return [];
        }
    }


    public function results($results)
    {
        $images = [];
        $counter=0;
        if (!empty($results['data'])) {
            foreach ($results['data'] as $photo) {
                $counter++;
                $images[] = [
                    'image' => $photo['images']['png'][512],
                    'large_preview' => $photo['images']['png'][512],
                    'preview' => $photo['images']['png'][512],
                ];
                 
            }
        }

        return [
            'images' => $images,
            'image_count' => ($results['metadata']['total'] ?? $counter),
        ];
       
    }
    
}
/* 
token=`curl -H "Content-Type: application/json" -X POST --data '{"apikey":""}' https://api.flaticon.com/v2/app/authentication | jq .data.token -r`
curl -H "Content-Type: application/json" -X GET 'https://api.flaticon.com/v2/search/icons/priority?q=face' -H "Authorization: Bearer $token"

  */