<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'states';
    protected $fillable = ['id','country_id','name'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
