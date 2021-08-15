<?php

namespace App\Models;

use App\Traits\Query;
use Illuminate\Database\Eloquent\Model;

class TagSubscription extends Model
{
    use Query;
    protected $table = 'tag_subscriptions';
    protected $fillable = ['id','taggable_type','taggable_id','tag_id','value','name'];

    public function Taggable()
    {
        return $this->morphTo();
    }
    
    public function SocialMedia()
    {
        return $this->belongsTo(Tag::class,'tag_id', 'id');
    }

    public function Tag()
    {
        return $this->belongsTo(Tag::class,'tag_id', 'id');
    }
}
