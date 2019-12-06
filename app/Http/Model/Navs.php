<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Navs extends Model
{
    protected $table='navs';
    protected $primaryKey='Id';
    public $timestamps=false;
    protected $guarded = [];
}
