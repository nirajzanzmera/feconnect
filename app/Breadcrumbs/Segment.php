<?php 

namespace App\Breadcrumbs;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
/**
 * 
 */
class Segment
{
    protected $request;
    protected $segment;
    protected $pos;

    function __construct(Request $request, $segment, $pos)
    {
        $this->request = $request;
        $this->segment = $segment;
        $this->pos = $pos -1;
    }

    public function name()
    {
        return Str::title($this->segment);
    }

    public function model()
    {
        $params = collect($this->request->route()->parameters());
        if($params->count() == 2) {
            if($this->pos == 1) {
                return $params->first();
            } else if($this->pos == 3) {
                return $params->last();
            } else {
                return NULL;
            }
        } else {
            return $params->where('id', $this->segment)->first();
        }

    }

    public function active()
    {
        return ($this->pos === count($this->request->segments())-1 ) ? true : false;
    }

    public function url()
    {
        return url(implode('/',array_slice($this->request->segments(), 0, $this->pos + 1)));
    }

   /* public function pos
    {
        var_dump($this->segment);
        return array_search($this->segment, $this->request->segments());
    }*/

}
