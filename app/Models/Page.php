<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    protected $table='pages';
    protected $fillable=['title','description'];

    public function Menus(){
        return $this->belongsToMany(Menus::class,'menu_page','page_id','menu_id');
    }
}

