<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Links extends Model
{
    protected $table='links';
    protected $primaryKey='Id';
    public $timestamps=false;
    protected $guarded = [];
}
