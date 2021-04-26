<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use HasFactory;

    protected $table='users';
    protected $primaryKey = 'id';
    //todo:should assign guard_name for spatie package
     Protected $guard_name ='web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fname',
        'lname',
        'email',
        'password',
        'avatar',
        'phone',
        'skills',
        'fields_follow',
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //todo:Many relation
    //todo:Make Relationships as Eloquent (1-M) User,Post (each User has many posts)
    public final function posts():object {
        return $this->hasMany(Post::class);
    }

     public function getJWTIdentifier()
     {
         // TODO: Implement getJWTIdentifier() method.
         return $this->getKey();
     }

     public function getJWTCustomClaims()
     {
         // TODO: Implement getJWTCustomClaims() method.
         return [];
     }
}
