<?php

namespace App\Models;

use App\Traits\Query;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use Query;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'product_details';
    protected $fillable = ['name','description'];
    
    public function BranchOffice()
    {
        return $this->belongsTo(BranchOffice::class, 'branch_office_id', 'id');
    }
    public function Categories()
    {
        return $this->morphToMany(Tag::class, 'taggable','tag_subscriptions')->withTimestamps();
    }
    public function Images()
    {
        return $this->morphMany(ImageSubscription::class, 'imageable');
    }

}
