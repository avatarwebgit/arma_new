<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\CategoryBlog;
use App\Models\category;
use Illuminate\Http\Request;




class BlogCategoryController extends Controller
{

    public function index()
    {
        $categories = CategoryBlog::all();
        return view('admin.blog.category.index', compact('categories'));
    }

    public function create()
    {

        return view('admin.blog.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:blog_category,title',

        ]);

        CategoryBlog::create(
            ['title' => $request->title]
        );
        session()->flash('success', 'New Category Created Successfully');
        return redirect()->route('admin.blog.category.index');
    }

    public function edit(CategoryBlog $category)
    {

        return view('admin.blog.category.edit', compact('category'));
    }

    public function update(Request $request, CategoryBlog $category)
    {
        $request->validate([
            'title' => 'required|unique:blog_category,title,' . $category->id,

        ]);

        $category->update(
            ['title' => $request->title]
        );
        session()->flash('success', 'Category Updated Successfully');
        return redirect()->route('admin.blog.category.index');
    }

    public function remove(Request $request)
    {
        $id=$request->id;
        $category=CategoryBlog::where('id',$id)->first();
        $category->delete();
        session()->flash('success', 'Category Deleted Successfully');
        return redirect()->route('admin.blog.category.index');
    }
}
