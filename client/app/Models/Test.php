<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'college',
        'course',
        'age',
        'birthday',
        'contact_number',
        'sex',
        'email',
        'total_score',
        'depression_level',
        'medical_history'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(TestAnswer::class);
    }

    public function facialExpressions()
    {
        return $this->hasMany(FacialExpression::class);
    }
} 