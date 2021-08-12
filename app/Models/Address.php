<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'addresses';
    protected $fillable = ['state_id','addressable_type','addressable_id','adress','city','latitude','longitude','active'];
    
    public function addressable()
    {
        return $this->morphTo();
    }
    
    public function state()
    {
        return $this->belongsTo(State::class,'state_id', 'id');
    }

}
