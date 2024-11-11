<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactAddress;
use App\Models\ContactHelp;
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
            'active_banner' => 'required',
            'banner' => 'nullable',
        ]);
        if ($request->has('banner')) {
            $env = env('UPLOAD_BANNER_PAGE');
            $banner = generateFileName($request->banner->getClientOriginalName());
            $request->banner->move(public_path($env), $banner);
        } else {
            $banner = null;
        }
        $page = Page::create([
            'title' => $request->title,
            'active_banner' => $request->active_banner,
            'description' => $request->description,
            'banner_description' => $request->banner_description,
            'banner' => $banner,
        ]);
        $page->Menus()->attach($request->menu);
        session()->flash('success', 'New Page Created Successfully');
        return redirect()->route('admin.pages.index');
    }

    public function edit(Page $page)
    {
        $menus = Menus::where('parent', 0)->get();
        $contact_addresses = [];
        $contact_helps = [];
        if ($page->id == 20) {
            $contact_addresses = ContactAddress::all();
            $contact_helps = ContactHelp::all();
        }
        return view('admin.pages.edit', compact('menus', 'page', 'contact_addresses', 'contact_helps'));
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'nullable|unique:pages,title,' . $page->id,
            'description' => 'nullable',
            'menu' => 'required',
            'active_banner' => 'required',
            'banner' => 'nullable|image',
        ]);
        if ($request->has('banner')) {
            $env = env('UPLOAD_BANNER_PAGE');
            $banner = generateFileName($request->banner->getClientOriginalName());
            $request->banner->move(public_path($env), $banner);
        } else {
            $banner = $page->banner;
        }
        if ($request->has('map')) {
            $env = env('UPLOAD_BANNER_PAGE');
            $map = generateFileName($request->map->getClientOriginalName());
            $request->map->move(public_path($env), $banner);
        } else {
            $map = $page->map;
        }

        if ($request->has('form_bg')) {
            $env = env('UPLOAD_BANNER_PAGE');
            $form_bg = generateFileName($request->form_bg->getClientOriginalName());
            $request->form_bg->move(public_path($env), $banner);
        } else {
            $form_bg = $page->form_bg;
        }

        $page->update([
            'title' => $request->title,
            'active_banner' => $request->active_banner,
            'description' => $request->description,
            'banner_description' => $request->banner_description,
            'banner' => $banner,
            'map' => $map,
            'form_bg' => $form_bg,
        ]);
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
