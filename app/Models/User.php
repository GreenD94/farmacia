<?php

namespace App\Models;

use App\Traits\Query;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Query;
    use HasFactory, Notifiable,HasApiTokens;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'photo_default',
        'birth_date'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function OfficeSubscriptions()
    {
        return $this->hasMany(OfficeSubscription::class,'user_id', 'id');
    }
    public function offices()
    {
        return $this->belongsToMany(BranchOffice::class,'office_subscriptions', 'user_id', 'branch_office_id');
    }
    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }
    public function SocialMediaSubscription()
    {
        return $this->morphMany(SocialMediaSubscription::class, 'subscribable');
    }

    
}
