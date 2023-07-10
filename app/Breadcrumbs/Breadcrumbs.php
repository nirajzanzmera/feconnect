<?php  

namespace App\Breadcrumbs;

use App\Breadcrumbs\Segment;
use Illuminate\Http\Request;

/**
 *
 */

class Breadcrumbs 
{
    protected $request;

    function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function segments()
    {
        $pos = 0;
        return collect($this->request->segments())->map(function($segment) use(&$pos){
            $pos++;
            return new Segment($this->request, $segment, $pos);
        })->toArray();
    }
}
