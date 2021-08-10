<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchOffice extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'branch_offices';
    protected $fillable = ['company_id','name','dni','phone','email'];

    
    public function OfficeSubscriptions()
    {
        return $this->hasMany(OfficeSubscription::class,'branch_office_id', 'id');
    }
    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }
}
