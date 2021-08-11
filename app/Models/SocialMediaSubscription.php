<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialMediaSubscription extends Model
{
    protected $table = 'social_media_subscriptions';
    protected $fillable = ['id','subscribable_type','tag_id','subscribable_id','name'];

    public function subscribable()
    {
        return $this->morphTo();
    }

    public function SocialMedia()
    {
        return $this->belongsTo(Tag::class,'tag_id');
    }
}
