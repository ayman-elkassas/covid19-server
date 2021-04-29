<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivateSituation extends Model
{
    use HasFactory;

    public final function blogUser():object {
        //todo: if does not put foreignKey null will return in your response
        return $this->belongsTo(User::class,'user_id');
    }

    public final function blogDoctor():object {
        //todo: if does not put foreignKey null will return in your response
        return $this->belongsTo(Doctor::class,'doctor_id');
    }
}
