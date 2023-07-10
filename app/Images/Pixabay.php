<?php

namespace App\Images;

use App\Images\ImageService;

class Pixabay extends ImageService
{
    public function __construct()
    {
        $key = 'PIXABAY_KEY';
        if (!empty(env($key))) {
            $this->pixabay = new \Pixabay\PixabayClient([
                'key' => env($key)
            ]);
        } else {
            $this->pixabay = [];
        }
    }

    public function searchImages(string $search, $page = 1)
    {
        if (!empty($this->pixabay)) {
            return $this->results(
                $this->pixabay->get([
                    'q' => $search, 
                    'safesearch' => 'true',
                    'page' => $page,
                ], true)
            );
        } else {
            return [];
        }
    }


    public function results($results)
    {
        $images = [];
        if (!empty($results['hits'])) {
            foreach ($results['hits'] as $hit) {
                $images[] = [
                    'image' => $hit['largeImageURL'],
                    'large_preview' => $hit['webformatURL'],
                    'preview' => $hit['previewURL'],
                    'author' => [
                        'name' => $hit['user'],
                        'link' => 'https://pixabay.com/users/' . $hit['user'] . '-' . $hit['user_id'], 
                    ],
                ]; 
            }
        }

        return [
            'images' => $images,
            'image_count' => !empty($results['totalHits']) ? $results['totalHits'] : [],
        ];
       
    }
    
}
