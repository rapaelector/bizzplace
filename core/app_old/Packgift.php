<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Packgift extends Model
{
    protected $guarded=[];
    public function users(){
        return $this->belongsToMany(User::class);
    }

}
