<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'class_id',
        
    ];

    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    public function classes()
    {
        return $this->belongsTo(ClassSetup::class);
    }

}