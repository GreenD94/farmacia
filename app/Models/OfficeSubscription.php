<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficeSubscription extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'office_subscriptions';
    protected $fillable = ['branch_office_id','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function BranchOffice()
    {
        return $this->belongsTo(BranchOffice::class,'branch_office_id');
    }
    public function StatusLogs()
    {
        return $this->hasMany(OfficeSubscriptionsStatusLog::class, 'office_subscription_id', 'id');
    }
    public function Statuses()
    {
        return $this->morphToMany(Tag::class, 'taggable','tag_subscriptions')->withTimestamps();
    }

}
