<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opportunities extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'organization_id',
        'title',
        'description',
        'category',
        'start_time',
        'end_time',
        'province',
        'district',
        'skills',
        'vol_number',
        'age',
        'benefit',
        'logoImage',
        'status'
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function applicants()
    {
        return $this->hasMany(Applicant::class);
    }
}
