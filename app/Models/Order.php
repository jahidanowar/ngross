<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function getCreatedTimeAttribute(){
        return Carbon::parse($this->created_at)->format('d/m/Y h:i A');
    }
}
