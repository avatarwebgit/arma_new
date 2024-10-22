<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderCategoryLine1 extends Model
{
    use HasFactory;

    protected $table = "header_category_line_1";
    protected $guarded = [];

    public function Headers(){
        return $this->hasMany(Header1::class,'cat_id','id');
    }
}
