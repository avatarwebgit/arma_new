<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Header1Request;
use App\Models\Header1;
use App\Models\HeaderCategoryLine1;
use App\Models\HeaderCurencies;
use Illuminate\Http\Request;

class Header1Controller extends Controller
{
    public function index()
    {
//        $items = header1::latest()->paginate(20);
        $items = HeaderCategoryLine1::orderBy('priority', 'asc')->get();
        return view('admin.header1.category_index', compact('items'));
    }

    public function create($cat)
    {
        $categories = HeaderCategoryLine1::all();
        $currencies = HeaderCurencies::all();
        return view('admin.header1.create', compact('categories', 'currencies','cat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'title_2' => 'required',
            'cat_id' => 'required',
            'number_1' => 'required',
            'number_2' => 'required',
            'number_3' => 'required',
            'currency' => 'required',
            'priority' => 'required',
        ]);
        try {

            $item=Header1::create($request->all());

            $type = 'success';
            $msg = 'The Item Has Been Created Successfully';

        } catch (\Exception $exception) {
            $type = 'failed';
            $msg = $exception->getMessage();
        }
        session()->flash($type, $msg);
        return redirect()->route('admin.header1.category.headers.list',['id'=>$item->cat_id]);
    }

    public function edit($id)
    {
        $categories = HeaderCategoryLine1::all();
        $currencies = HeaderCurencies::all();
        $item = Header1::where('id', $id)->first();
        return view('admin.header1.edit', compact('item', 'categories', 'currencies'));
    }

    public function update(Header1Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'title_2' => 'required',
            'cat_id' => 'required',
            'number_1' => 'required',
            'number_2' => 'required',
            'number_3' => 'required',
            'currency' => 'required',
            'priority' => 'required',
        ]);
        $item = Header1::where('id', $id)->first();
        $item->update($request->all());
        return redirect()->route('admin.header1.category.headers.list',['id'=>$item->cat_id])
            ->with('success', __('Header 1 updated successfully.'));
    }

    public function remove($id)
    {
        try {
            $item = Header1::findOrFail($id);

            $item->delete();
            $message = 'The Item Has Been Deleted Successfully';

            return redirect()->back()->with('success', __($message));
        } catch (\Exception $exception) {

            return redirect()->back()->with('failed', __($exception->getMessage()));
        }


    }

    public function headers(HeaderCategoryLine1 $id)
    {
        $items = $id->Headers()->orderBy('priority', 'asc')->get()->groupBy('priority');
        return view('admin.header1.index', compact('items','id'));
    }

    public function headers_create()
    {
        return view('admin.header1.category_create');
    }

    public function headers_edit(HeaderCategoryLine1 $id)
    {
        return view('admin.header1.category_edit', compact('id'));
    }

    public function headers_update(Request $request, HeaderCategoryLine1 $id)
    {
        $request->validate([
            'title' => 'required|unique:header_category,title,' . $id->id,
            'priority' => 'required'
        ]);
        $id->update([
            'title' => $request->title,
            'priority' => $request->priority,
        ]);
        $message = 'The Item Has Been Updated Successfully';
        return redirect()->back()->with('success', __($message));
    }

    public function headers_store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:header_category,title',
            'priority' => 'required'
        ]);
        HeaderCategoryLine1::create([
            'title' => $request->title,
            'priority' => $request->priority,
        ]);
        $message = 'The Item Has Been Created Successfully';
        return redirect()->back()->with('success', __($message));
    }

    public function headers_remove($id)
    {
        try {
            $item = HeaderCategoryLine1::findOrFail($id);
            $headers = $item->Headers;
            foreach ($headers as $header) {
                $header->delete();
            }
            $item->delete();
            $message = 'The Item Has Been Deleted Successfully';
            return redirect()->back()->with('success', __($message));
        } catch (\Exception $exception) {

            return redirect()->back()->with('failed', __($exception->getMessage()));
        }


    }
}
