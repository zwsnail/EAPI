<?php
namespace App;
use App\Model\Product;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    //这个地方是运行了passport后要加的字段，HasApiTokens
    use HasApiTokens,Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //这个是我改造的地方
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}