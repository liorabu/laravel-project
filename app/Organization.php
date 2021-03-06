<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    public function user(){
        return $this->hasMany('App\user');

    }
    public function detail(){
        return $this->hasMany('App\Detail');
    }
    protected $fillable = [
                'org_name', 'owner_name','owner_id','schedule'
           ];
}
