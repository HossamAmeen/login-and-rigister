<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerifyPhone extends Model
{
    protected $fillable = [
        'code' , 'user_id' ];
}
