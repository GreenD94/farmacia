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
    protected $fillable = ['addressable_type','addressable_id','adress','city','latitude','longitude','background_color','main_color','secondary_color','text_one_color','text_two_color','logo_white','active'];
    public function addressable()
    {
        return $this->morphTo();
    }
    

}
