<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    public function organization(){
        return $this->belongsTo('App\Organization');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function meeting(){
        return $this->belongsTo('App\Meeting');
    }
}
