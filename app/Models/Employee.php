<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'salary', 'address', 'nid', 'joining_date', 'photo'];

    public function getPhotoAttribute($value)
    {
        return asset($value);
    }
}
