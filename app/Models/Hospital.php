<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'address'
    ];

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function members(){
        return $this->belongsToMany(User::class);
    }

    public function departments(){
        return $this->belongsToMany(Department::class);
    }


}
