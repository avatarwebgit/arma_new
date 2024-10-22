<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeaderCategory;
use Illuminate\Http\Request;

class HeaderCategoryController extends Controller
{
    public function index()
    {
        $categories = HeaderCategory::all();
        return view('admin.header_category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.header_category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:header_category,title',
        ]);
        HeaderCategory::create($request->all());
        session()->flash('success', 'New Category Created Successfully');
        return redirect()->route('admin.header_categories.index');
    }

    public function edit(HeaderCategory $category)
    {
        return view('admin.header_category.edit', compact('category'));
    }

    public function update(Request $request,HeaderCategory $category)
    {
        $request->validate([
            'title' => 'required|unique:header_category,title,' . $category->id,
        ]);
        $category->update($request->all());
        session()->flash('success', 'Category Updated Successfully');
        return redirect()->route('admin.header_categories.index');
    }

    public function remove(Request $request)
    {
        $id=$request->id;
        $category=HeaderCategory::where('id',$id)->first();
        $category->delete();
        session()->flash('success', 'Category Deleted Successfully');
        return redirect()->route('admin.header_categories.index');
    }
}
