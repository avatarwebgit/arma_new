<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table = "blogs";
    protected $guarded = [];

    public function Category()
    {
        return $this->belongsTo(CategoryBlog::class,'category_id');
    }
}
