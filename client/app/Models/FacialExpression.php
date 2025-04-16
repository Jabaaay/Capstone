<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacialExpression extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_id',
        'emotion',
        'confidence',
        'timestamp'
    ];

    protected $casts = [
        'confidence' => 'float',
        'timestamp' => 'datetime'
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }
} 