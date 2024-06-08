<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Header2Request;
use App\Models\Header2;
use App\Models\HeaderCategory;
use App\Models\HeaderCurencies;
use http\Env\Request;

class Header2Controller extends Controller
{
    public function index()
    {
        $items = Header2::latest()->paginate(20);
        return view('admin.header2.index', compact('items'));
    }

    public function create()
    {
        $categories = HeaderCategory::all();
        $currencies = HeaderCurencies::all();
        return view('admin.header2.create', compact('categories','currencies'));
    }


    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
           'title'=>'required',
           'title_2'=>'required',
           'category'=>'required',
           'number_1'=>'required',
           'number_2'=>'required',
           'number_3'=>'required',
           'currency'=>'required',
           'priority'=>'required',
        ]);
        try {
            $header = Header2::create($request->all());
            if ($request->category != null) {
                $header->Categories()->detach();
                $header->Categories()->attach($request->category);
            }

            $type = 'success';
            $msg = 'The Item Has Been Created Successfully';

        } catch (\Exception $exception) {
            $type = 'failed';
            $msg = $exception->getMessage();
        }
        session()->flash($type, $msg);
        return redirect()->route('admin.header2.index');
    }

    public function edit($id)
    {
        $categories = HeaderCategory::all();
        $currencies = HeaderCurencies::all();
        $item = Header2::where('id', $id)->first();
        return view('admin.header2.edit', compact('item', 'categories','currencies'));
    }

    public function update(Header2Request $request, $id)
    {
        $item = Header2::where('id', $id)->first();
        $item->update($request->all());
        $item->Categories()->detach();
        if ($request->category != null) {
            $item->Categories()->attach($request->category);
        }
        return redirect()->route('admin.header2.index')
            ->with('success', __('Header 2 updated successfully.'));
    }

    public function remove($id)
    {
        try {
            $item = Header2::findOrFail($id);

            $item->delete();
            $message = 'The Item Has Been Deleted Successfully';

            return redirect()->back()->with('success', __($message));
        } catch (\Exception $exception) {

            return redirect()->back()->with('failed', __($exception->getMessage()));
        }


    }
}
