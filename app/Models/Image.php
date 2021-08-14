<?php

namespace App\Models;

use App\Traits\Query;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use Query;
    protected $table = 'images';
    protected $fillable = ['id','name','path','imageable_type','imageable_id','tag_id'];

    public function Imageable()
    {
        return $this->morphTo();
    }

    public function Tag()
    {
        return $this->belongsTo(Tag::class,'tag_id','id');
    }
}
