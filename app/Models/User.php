<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];


    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function products()
    {
        if ($this->user_type == 'vendor') {
            return $this->hasMany(Product::class, 'vendor_id');
        }
    }

    public function vendorOrders()
    {
        // https://stackoverflow.com/questions/54444592/laravel-eloquent-get-a-record-every-hour
        //https://laracasts.com/discuss/channels/laravel/count-rows-grouped-by-hours-of-the-day
        $result = [];
        foreach ($this->products as $product) {
            $orders = OrderProduct::where([
                ['product_id', '=', $product->id],
                ['status', '=', 0],
            ])->orderBy('created_at', 'ASC')->get();
            if (count($orders) > 0) {
                $quantity = 0;
                foreach ($orders as $order) {
                    $quantity += $order->quantity;
                }
                $response = array(
                    "product_id" => $product->id,
                    "product_name" => $product->title,
                    "quantity" => $quantity,
                    "orders" => $orders,
                );
                array_push($result, $response);
            }
        }
        return $result;
    }

    public function vendors(){
        if($this->user_type === "manager"){
            return $this->hasMany(User::class, 'manager_id');
        }
    }
}
