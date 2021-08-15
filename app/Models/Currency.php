<?php

namespace App\Models;

use App\Traits\Query;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use Query;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'currencies';
    protected $fillable = ['value','tag_id','branch_office_id'];

    public function tag()
    {
        return $this->belongsTo(Tag::class,'tag_id', 'id');
    }

}
