<?php

namespace Modules\Setting\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Setting extends Model
{
    use HasFactory;
    protected $table = "'settings";
    protected $fillable = [
        "key",
        "value",
    ];
    protected $casts = [
        "value" => "string",
    ];

}
