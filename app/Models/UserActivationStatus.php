<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivationStatus extends Model
{
    use HasFactory;

    protected $table = "user_activation_status";
    protected $guarded = [];
}
