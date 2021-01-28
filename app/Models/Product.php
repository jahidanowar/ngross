<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

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
        'stock',

    ];

    public function orders(){
        return $this->belongsToMany(Order::class)->withPivot('quantity');
    }

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function user(){
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function getImageAttribute($value){
        $value = str_replace("public", "", $value);
        return url("storage".$value);
    }
}
