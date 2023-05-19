<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassSetup extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'size',
        'learner_with_SEN',
        'location',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}