<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table    = 'branches';
    protected $fillable = [
        'business_id',
        'name',
        'images',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function availability()
    {
        return $this->hasMany(BranchAvailability::class, 'branch_id');
    }
}
