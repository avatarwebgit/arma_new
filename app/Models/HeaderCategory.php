<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderCategory extends Model
{
    use HasFactory;
    protected $table='header_category';
    protected $fillable=['title'];

    public function Headers(){
        return $this->belongsToMany(Header2::class,'category_header2','category_id','header2_id');
    }
}
