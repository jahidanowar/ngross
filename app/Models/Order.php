<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
    ];

    public function products(){
        return $this->belongsToMany('App\Models\Product')->withPivot('quantity');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
