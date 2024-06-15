<?php

namespace App\Http\Controllers\Admin;

use App\Events\LIneHeaderUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Header2Request;
use App\Models\Header2;
use App\Models\HeaderCategory;
use App\Models\HeaderCurencies;
use Illuminate\Http\Request;

class Header2Controller extends Controller
{
    public function index()
    {
//        $items = Header2::latest()->paginate(20);
        $items = HeaderCategory::orderBy('priority', 'asc')->get();
        return view('admin.header2.category_index', compact('items'));
    }

    public function create()
    {
        $categories = HeaderCategory::all();
        $currencies = HeaderCurencies::all();
        return view('admin.header2.create', compact('categories', 'currencies'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'title_2' => 'nullable',
            'category' => 'required',
            'number_1' => 'nullable|numeric',
            'number_2' => 'nullable|numeric',
            'number_3' => 'nullable|numeric',
            'currency' => 'nullable',
            'priority' => 'required',
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
        $header2_categories = HeaderCategory::orderBy('priority', 'asc')->get();
        $html=view('home.sections.header1',compact('header2_categories'))->render();
        broadcast(new LIneHeaderUpdated($html,1,null));
        return redirect()->route('admin.header2.index');
    }

    public function edit($id)
    {
        $categories = HeaderCategory::all();
        $currencies = HeaderCurencies::all();
        $item = Header2::where('id', $id)->first();
        return view('admin.header2.edit', compact('item', 'categories', 'currencies'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'title_2' => 'nullable',
            'category' => 'required',
            'number_1' => 'nullable|numeric',
            'number_2' => 'nullable|numeric',
            'number_3' => 'nullable|numeric',
            'currency' => 'nullable',
            'priority' => 'required',
        ]);
        $item = Header2::where('id', $id)->first();
        $item->update($request->all());
        $item->Categories()->detach();
        if ($request->category != null) {
            $item->Categories()->attach($request->category);
        }
        $cat = $item->Categories[0]->id;
        $html=view('home.sections.header2_row',compact('item'))->render();
        broadcast(new LIneHeaderUpdated($html,2,$item->id));
        return redirect()->route('admin.header2.category.headers.list', ['id' => $cat])
            ->with('success', __('Header 2 updated successfully.'));
    }

    public function remove($id)
    {
        try {
            $item = Header2::findOrFail($id);

            $item->delete();
            $message = 'The Item Has Been Deleted Successfully';
            $header2_categories = HeaderCategory::orderBy('priority', 'asc')->get();
            $html=view('home.sections.header1',compact('header2_categories'))->render();
            broadcast(new LIneHeaderUpdated($html,1,null));
            return redirect()->back()->with('success', __($message));
        } catch (\Exception $exception) {

            return redirect()->back()->with('failed', __($exception->getMessage()));
        }


    }


    public function headers(HeaderCategory $id)
    {
        $items = $id->Headers()->orderBy('priority', 'asc')->get()->groupBy('priority');
        return view('admin.header2.index', compact('items'));
    }

    public function headers_create()
    {
        return view('admin.header2.category_create');
    }

    public function headers_edit(HeaderCategory $id)
    {
        return view('admin.header2.category_edit', compact('id'));
    }

    public function headers_update(Request $request, HeaderCategory $id)
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
        HeaderCategory::create([
            'title' => $request->title,
            'priority' => $request->priority,
        ]);
        $message = 'The Item Has Been Created Successfully';
        return redirect()->back()->with('success', __($message));
    }

    public function headers_remove($id)
    {
        try {
            $item = HeaderCategory::findOrFail($id);
            $headers = $item->Headers;
            foreach ($headers as $header) {
                $header->delete();
            }
            $item->delete();
            $message = 'The Item Has Been Deleted Successfully';
            $header2_categories = HeaderCategory::orderBy('priority', 'asc')->get();
            $html=view('home.sections.header1',compact('header2_categories'))->render();
            broadcast(new LIneHeaderUpdated($html,1,null));
            return redirect()->back()->with('success', __($message));
        } catch (\Exception $exception) {

            return redirect()->back()->with('failed', __($exception->getMessage()));
        }


    }
}
