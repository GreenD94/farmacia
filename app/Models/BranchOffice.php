<?php

namespace App\Models;

use App\Traits\Query;
use Illuminate\Database\Eloquent\Model;

class  BranchOffice extends Model
{
    use Query;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'branch_offices';
    protected $fillable = ['company_id','name','dni','phone','email','active'];

    
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
    public function Users()
    {
        return $this->belongsToMany(User::class,'office_subscriptions', 'branch_office_id','user_id');
    }
    public function Products()
    {
        return $this->hasMany(Product::class, 'branch_office_id', 'id');
    }
    public function ProductDetails()
    {
        return $this->belongsToMany(ProductDetail::class, 'products', 'branch_office_id', 'product_detail_id')->withTimestamps();
    } 
    public function Currency()
    {
        return $this->hasMany(Currency::class, 'branch_office_id', 'id');
    }
    public function Colors()
    {
        return $this->morphMany(TagSubscription::class, 'taggable');
    }
    public function Images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
