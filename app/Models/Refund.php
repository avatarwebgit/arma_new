<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    use HasFactory;

    protected $table = "refunds";
    protected $guarded = [];

    public function Status()
    {
        return $this->belongsTo(RefundStatus::class, 'status', 'id');
    }
    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
