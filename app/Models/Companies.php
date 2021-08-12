<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'companies';
    protected $fillable = ['name'];

    
    public function BranchOffices()
    {
        return $this->hasMany(BranchOffice::class,'company_id', 'id');
    }

}
