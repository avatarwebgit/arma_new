<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Header2 extends Model
{
    use HasFactory;
    protected $table="header2";
    protected $guarded=[''];

    public function Categories(){
        return $this->belongsToMany(HeaderCategory::class,'category_header2','header2_id','category_id');
    }
}
