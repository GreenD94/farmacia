<?php

namespace App\Models;

use App\Traits\Query;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Query;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'products';
    protected $fillable = ['branch_office_id','product_detail_id','price','show_price','available'];
    
    public function BranchOffice()
    {
        return $this->belongsTo(BranchOffice::class, 'branch_office_id', 'id');
    }
    public function ProductDetail()
    {
        return $this->belongsTo(ProductDetail::class, 'product_detail_id', 'id');
    }
    public function Images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
    

}
