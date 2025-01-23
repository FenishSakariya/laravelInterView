<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $table    = 'businesses';
    protected $fillable = [
        'email',
        'name',
        'phone',
        'logo',
    ];

    public function branches()
    {
        return $this->hasMany(Branch::class, 'business_id');
    }
}
