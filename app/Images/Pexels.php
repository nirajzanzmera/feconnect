<?php

namespace App\Images;

use App\Images\ImageService;

class Pexels extends ImageService
{
    public function __construct()
    {
        $key = env('PEXELS_KEY');
        if ( !empty($key) ) {
            $this->pexels = new \Glooby\Pexels\Client($key);
        } else {
            $this->pexels = [];
        }

    }

    public function searchImages(string $search, $page = 1)
    {
        if (!empty($this->pexels)) {
            $res = $this->pexels->search($search, 20, $page)->getBody();
            $photos = json_decode($res, true);
            return $this->results( $photos );
        } else {
            return [];
        }
    }


    public function results($results)
    {
        $images = [];
        if (!empty($results['photos'])) {
            foreach ($results['photos'] as $photo) {
                $images[] = [
                    'image' => $photo['src']['large2x'],
                    'large_preview' => $photo['src']['large'],
                    'preview' => $photo['src']['medium'],
                    'author' => [
                        'name' => $photo['photographer'],
                        'link' => $photo['photographer_url'], 
                    ],
                ]; 
            }
        }

        return [
            'images' => $images,
            'image_count' => !empty($results['total_results']) ? $results['total_results'] : [],
        ];
       
    }
    
}
/* 
 +"id": 792416
      +"width": 4167
      +"height": 2976
      +"url": "https://www.pexels.com/photo/photography-of-small-blue-and-brown-bird-792416/"
      +"photographer": "Tina Nord"
      +"photographer_url": "https://www.pexels.com/@nord6"
      +"photographer_id": 259428
      +"avg_color": "#A4A3A5"
      +"src": {#3914
        +"original": "https://images.pexels.com/photos/792416/pexels-photo-792416.jpeg"
        +"large2x": "https://images.pexels.com/photos/792416/pexels-photo-792416.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940"
        +"large": "https://images.pexels.com/photos/792416/pexels-photo-792416.jpeg?auto=compress&cs=tinysrgb&h=650&w=940"
        +"medium": "https://images.pexels.com/photos/792416/pexels-photo-792416.jpeg?auto=compress&cs=tinysrgb&h=350"
        +"small": "https://images.pexels.com/photos/792416/pexels-photo-792416.jpeg?auto=compress&cs=tinysrgb&h=130"
        +"portrait": "https://images.pexels.com/photos/792416/pexels-photo-792416.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=1200&w=800"
        +"landscape": "https://images.pexels.com/photos/792416/pexels-photo-792416.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=627&w=1200"
        +"tiny": "https://images.pexels.com/photos/792416/pexels-photo-792416.jpeg?auto=compress&cs=tinysrgb&dpr=1&fit=crop&h=200&w=280"
      }
      +"liked": false
    }
  ]

  */