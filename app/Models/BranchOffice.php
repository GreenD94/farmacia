<?php

namespace App\Models;

use App\Traits\Query;
use Illuminate\Database\Eloquent\Model;

class BranchOffice extends Model
{
    use Query;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'branch_offices';
    protected $fillable = ['company_id','name','dni','phone','email','background_color','main_color','secondary_color','text_one_color','text_two_color','logo_white','active'];

    
    public function OfficeSubscriptions()
    {
        return $this->hasMany(OfficeSubscription::class,'branch_office_id', 'id');
    }
    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function Company()
    {
        return $this->belongsTo(Companies::class, 'company_id', 'id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class,'office_subscriptions', 'branch_office_id','user_id');
    }
}
