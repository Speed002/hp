<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'code_name'
    ];

    public function hospitals(){
        return $this->belongsToMany(Hospital::class);
    }

    public function services(){
        return $this->hasMany(Service::class);
    }

}
