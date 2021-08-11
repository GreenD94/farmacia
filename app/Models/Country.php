<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    //
    protected $primaryKey = 'id';
    protected $table = 'countries';
    protected $fillable = ['code', 'name','image'];

    public function states()
    {

        return $this->hasMany(State::class, 'country_id');
    }
}
