<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketPermission extends Model
{
    use HasFactory;

    protected $table = "market_permission";
    protected $guarded = [];
}
