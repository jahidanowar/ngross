<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $with = [
        'categories'
    ];

    protected $fillable = [
        'slug',
        'title',
        'price',
        'discounted_price',
        'description',
        'image',
        'vendor_id',

    ];

    

    public function categories(){
        return $this->belongsToMany(Category::class);
    }
}
