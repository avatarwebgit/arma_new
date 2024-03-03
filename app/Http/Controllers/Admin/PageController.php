<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menus;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::all();
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        $menus = Menus::where('parent', 0)->get();
        return view('admin.pages.create', compact('menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|unique:pages,title',
            'description' => 'nullable',
            'menu' => 'required',
        ]);
        $page=Page::create($request->all());
        $page->Menus()->attach($request->menu);
        session()->flash('success', 'New Page Created Successfully');
        return redirect()->route('admin.pages.index');
    }

    public function edit(Page $page)
    {
        $menus = Menus::where('parent', 0)->get();
        return view('admin.pages.edit', compact('menus','page'));
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'nullable|unique:pages,title,'.$page->id,
            'description' => 'nullable',
            'menu' => 'required',
        ]);
        $page->update($request->all());
        $page->Menus()->detach();
        $page->Menus()->attach($request->menu);
        session()->flash('success', 'Page Updated Successfully');
        return redirect()->route('admin.pages.index');
    }

    public function remove(Request $request)
    {
        $id = $request->id;
        $page = Page::where('id', $id)->first();
        $page->delete();
        session()->flash('success', 'Menu Deleted Successfully');
        return redirect()->route('admin.pages.index');
    }
}
