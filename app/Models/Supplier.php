<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';

    protected $fillable = ['name', 'email', 'phone', 'shop_name', 'address', 'photo'];

    public function getPhotoAttribute($value)
    {
        return asset($value);
    }
}
