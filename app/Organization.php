<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
                'org_name', 'owner_name','owner_id',
           ];
}
