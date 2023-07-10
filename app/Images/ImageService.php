<?php
namespace App\Images;


abstract class ImageService {

    abstract public function searchImages(string $term, $page = 1);
    
    public function search(String $term, $page = 1)
    {
        return $this->searchImages($term, $page);
    }

}
