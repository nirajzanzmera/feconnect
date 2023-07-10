<?php
 
namespace App;
 
use Illuminate\Database\Eloquent\Model; 
use App\Helper\Helper;
use App\Engagements;

class ExternalTrigger extends Engagements
{
    protected $type = 'externaltrigger';
}