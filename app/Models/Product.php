<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'products';
    protected $softDelete = true;

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

    public function user(){
        return $this->belongsTo(User::class, 'vendor_id');
    }
}
