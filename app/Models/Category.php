<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Category extends Model
{
    use HasFactory, HasApiTokens;


    protected $fillable = [
        'slug',
        'title'
    ];

    public function products(){
        return $this->belongsToMany(Product::class);
    }

}