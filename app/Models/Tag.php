<?php

namespace App\Models;

use App\Traits\Query;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use Query;
    protected $table = 'tags';
    protected $fillable = ['id','name','type'];

   
}
