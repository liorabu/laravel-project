<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function user(){
        return $this->hasMany('App\User');
    }

    protected $fillable = [
        'description', 'participator_id', 'due_date', 'org_id',
    ];
}


