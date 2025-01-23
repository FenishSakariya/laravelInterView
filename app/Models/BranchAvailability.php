<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchAvailability extends Model
{
    protected $table = 'branch_availabilities';

    protected $fillable = [
        'branch_id',
        'day',
        'start_time',
        'end_time',
        'specific_date',
        'status',
    ];
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
