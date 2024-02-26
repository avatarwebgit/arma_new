<?php

namespace App\Http\Controllers\Admin;

use App\Events\MarketTimeUpdated;
use App\Http\Controllers\Controller;
use App\Models\Market;
use App\Models\Menus;
use App\Models\SalesOfferForm;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menus::all();
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        $parent_menus = Menus::where('parent', 0)->get();
        return view('admin.menus.create', compact('parent_menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:menus,title',
            'parent' => 'required',
            'priority' => 'required',
        ]);
        Menus::create($request->all());
        session()->flash('success', 'New Menu Created Successfully');
        return redirect()->route('admin.menus.index');
    }

    public function edit(Menus $menu)
    {
        $parent_menus = Menus::where('parent', 0)->get();
        return view('admin.menus.edit', compact('parent_menus', 'menu'));
    }

    public function update(Request $request, Menus $menu)
    {
        $request->validate([
            'title' => 'required|unique:menus,title,' . $menu->id,
            'parent' => 'required',
            'priority' => 'required',
        ]);
        $menu->update($request->all());
        session()->flash('success', 'Menu Updated Successfully');
        return redirect()->route('admin.menus.index');
    }

    public function remove(Request $request)
    {
       $id=$request->id;
       $menu=Menus::where('id',$id)->first();
       $menu->delete();
        session()->flash('success', 'Menu Deleted Successfully');
        return redirect()->route('admin.menus.index');
    }
}
