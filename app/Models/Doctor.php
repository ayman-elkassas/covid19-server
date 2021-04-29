<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Doctor extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use Notifiable;

    protected $table='doctors';
    protected $primaryKey = 'id';
    //todo:should assign guard_name for spatie package
    Protected $guard_name ='web1';

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

    //todo:Many relation
    //todo:Make Relationships as Eloquent (1-M) User,Post (each User has many posts)
//    public final function doctor():object {
//        return $this->hasMany(User::class, 'id','parent_id');
//    }
//
//    public final function patients():object {
//        return $this->doctor()->with(["patients","posts"]);
//    }

    public function patients()
    {
        return $this->belongsToMany(User::class);
    }

    public function reports()
    {
        return $this->belongsToMany(User::class,'treatment_reports')
            ->withPivot('title', 'desc')
            ->withTimestamps();
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
