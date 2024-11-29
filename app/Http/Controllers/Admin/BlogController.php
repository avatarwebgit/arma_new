<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NewsMail;
use App\Models\CategoryBlog;
use App\Models\Blog;
use App\Models\UserNews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BlogController extends Controller
{

    public function index()
    {
        $Blogs = Blog::paginate(20);
        return view('admin.blog.index', compact('Blogs'));
    }

    public function create()
    {
        $CategoryBlog = CategoryBlog::all();
        return view('admin.blog.create', compact('CategoryBlog'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'short_description' => 'required',

        ]);
        if ($request->has('image')) {
            $env = env('UPLOAD_IMAGE_BLOG');
            $image= generateFileName($request->image->getClientOriginalName());
            $request->image->move(public_path($env), $image);
        } else {
            $image = null;
        }
        $Blog=Blog::create([
            'title'=>$request->title,
            'category_id'=>$request->category_id,
            'short_description'=>$request->short_description,
            'description'=>$request->description,
            'image'=>$image,
        ]);


        if ($request->send_news){
            $Blog->update([
                'send_news'=>1
            ]);
            $users = UserNews::all();
            $blog = [
                'title'=>$request->title,
                'short_description'=>$request->short_description,
            ];
            foreach ($users as $user){
                Mail::to($user->email)->send(new NewsMail($blog));
            }
        }

        session()->flash('success', 'New Blog Created Successfully');
        return redirect()->route('admin.blog.index');
    }

    public function edit(Blog $blog)
    {
        $CategoryBlog = CategoryBlog::all();
        return view('admin.blog.edit', compact('CategoryBlog','blog'));
    }

    public function update(Request $request, Blog $Blog)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'nullable',
            'description' => 'required',
            'category_id' => 'nullable',
            'short_description' => 'required',
        ]);

        if ($request->has('image') and $request->image != null) {
            $env = env('UPLOAD_IMAGE_BLOG');
            $image= generateFileName($request->image->getClientOriginalName());
            $request->image->move(public_path($env), $image);
        } else {
            $image = $Blog->image;
        }

        $Blog->update([
            'title'=>$request->title,
            'category_id'=>$request->category_id,
            'short_description'=>$request->short_description,
            'description'=>$request->description,
            'image'=>$image,
        ]);
        if ($Blog->send_news != 1){
            $Blog->update([
                'send_news'=>1
            ]);
            $users = UserNews::all();
            $blog = [
                'title'=>$request->title,
                'short_description'=>$request->short_description,
            ];
            foreach ($users as $user){
                Mail::to($user->email)->send(new NewsMail($blog));
            }
        }

        session()->flash('success', 'Blog Updated Successfully');
        return redirect()->route('admin.blog.index');
    }

    public function join_news(Request $request)
    {

        UserNews::create([
            'email'=>$request->email
        ]);
        session()->flash('success', 'Join has been Successfully');
        return redirect()->route('home.index');

    }

    public function remove(Request $request)
    {
        $id = $request->id;
        $Blog = Blog::where('id', $id)->first();
        $Blog->delete();
        session()->flash('success', 'Blog Deleted Successfully');
        return redirect()->route('admin.blog.index');
    }
}
