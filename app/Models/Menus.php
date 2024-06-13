<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
    use HasFactory;

    protected $table = 'menus';
    protected $fillable = ['title', 'parent','show_on_footer','show_on_header','priority'];

    public function Pages()
    {
        return $this->belongsToMany(Page::class, 'menu_page', 'menu_id','page_id');
    }

    public function children()
    {
        return $this->hasMany(Menus::class, 'parent', 'id');
    }

    public function Parent()
    {
        return $this->belongsTo(Menus::class, 'parent', 'id');
    }
}
