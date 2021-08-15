<?php

namespace App\Models;

use App\Traits\Query;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use Query;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'addresses';
    protected $fillable = ['state_id','addressable_type','addressable_id','adress','city','latitude','longitude','active'];
    
    public function Addressable()
    {
        return $this->morphTo();
    }
    
    public function State()
    {
        return $this->belongsTo(State::class,'state_id', 'id');
    }

}
