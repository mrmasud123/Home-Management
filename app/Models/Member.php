<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    
    protected $guarded=[];

    public function meals(){
        return $this->hasMany(Meal::class);
    }

    public function bazar(){
        return $this->hasMany(Bazar::class);
    }

}
