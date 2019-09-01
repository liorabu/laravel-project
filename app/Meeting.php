<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    public function user(){
        return $this->hasMany('App\User');
    }
    
    public function organization(){
        return $this->belongsTo('App\Organization');
    }
    public function detail(){
        return $this->hasMany('App\Detail');
    }
    protected $fillable = [
        'title', 'date',
   ];
}
