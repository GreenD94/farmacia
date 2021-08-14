<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficeSubscriptionsStatusLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'office_subscriptions_status_logs';
    protected $fillable = ['office_subscription_id','tag_id'];



    public function Tag()
    {
        return $this->belongsTo(Tag::class,'tag_id', 'id');
    }

}
