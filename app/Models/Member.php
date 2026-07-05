<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Member extends Authenticatable
{

    use Notifiable;

    protected $fillable = [
        'email',
        'name',
        'google_id',
        'avatar',
        'joined_date',
        'status',
        'seat_rent',
    ];

    protected $hidden = ['remember_token'];

    protected $casts = [
        'joined_date' => 'date:Y-m-d',
//        'status' => 'boolean',
    ];

    protected $guarded=[];

    public function meals(){
        return $this->hasMany(Meal::class);
    }

    public function bazar(){
        return $this->hasMany(Bazar::class);
    }

}
