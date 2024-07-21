<?php

namespace App\Http\Controllers\Admin;

use App\Events\LIneHeaderUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Header1Request;
use App\Models\Header1;
use App\Models\HeaderCategoryLine1;
use App\Models\HeaderCurencies;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Header1Controller extends Controller
{
    public function index()
    {
//        $items = header1::latest()->paginate(20);
        $items = HeaderCategoryLine1::orderBy('priority', 'asc')->get();
        $speed = Setting::where('key', 'start_market')->pluck('value')->first();
        return view('admin.header1.category_index', compact('items','speed'));
    }

    public function create($cat)
    {
        $categories = HeaderCategoryLine1::all();
        $currencies = HeaderCurencies::all();
        return view('admin.header1.create', compact('categories', 'currencies', 'cat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'title_2' => 'nullable',
            'cat_id' => 'required',
//            'number_1' => 'nullable|numeric',
            'number_2' => 'nullable|numeric',
            'number_3' => 'nullable|numeric',
            'currency' => 'nullable|nullable',
            'priority' => 'required',
        ]);
        try {
            $request['number_1'] = 0;
            $item = Header1::create($request->all());

            $type = 'success';
            $msg = 'The Item Has Been Created Successfully';

        } catch (\Exception $exception) {
            $type = 'failed';
            $msg = $exception->getMessage();
        }
        $header1_categories = HeaderCategoryLine1::orderBy('priority', 'asc')->where('status', 1)->get();
        $html = view('home.sections.header1', compact('header1_categories'))->render();
        broadcast(new LIneHeaderUpdated($html, 1, null));
        session()->flash($type, $msg);
        return redirect()->route('admin.header1.category.headers.list', ['id' => $item->cat_id]);
    }

    public function edit($id)
    {
        $categories = HeaderCategoryLine1::all();
        $currencies = HeaderCurencies::all();
        $item = Header1::where('id', $id)->first();
        return view('admin.header1.edit', compact('item', 'categories', 'currencies'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'title_2' => 'nullable',
            'cat_id' => 'required',
//            'number_1' => 'nullable|numeric',
            'number_2' => 'nullable|numeric',
            'number_3' => 'nullable|numeric',
            'currency' => 'nullable|nullable',
            'priority' => 'required',
        ]);
        $request['number_1'] = 0;
        $request['updated_at'] = Carbon::now();
        $item = Header1::where('id', $id)->first();
        $item->update($request->all());
        $html = view('home.sections.header1_row', compact('item'))->render();
        broadcast(new LIneHeaderUpdated($html, 1, $item->id));
        return redirect()->route('admin.header1.category.headers.list', ['id' => $item->cat_id])
            ->with('success', __('Header 1 updated successfully.'));
    }

    public function remove($id)
    {
        try {
            $item = Header1::findOrFail($id);

            $item->delete();
            $message = 'The Item Has Been Deleted Successfully';
            $header1_categories = HeaderCategoryLine1::orderBy('priority', 'asc')->where('status', 1)->get();
            $html = view('home.sections.header1', compact('header1_categories'))->render();
            broadcast(new LIneHeaderUpdated($html, 1, null));

            return redirect()->back()->with('success', __($message));
        } catch (\Exception $exception) {

            return redirect()->back()->with('failed', __($exception->getMessage()));
        }


    }

    public function change_status(Request $request)
    {
        try {
            $id = $request->id;
            $status = $request->value == 'true' ? 1 : 0;
            $item = Header1::findOrFail($id);
            $item->update([
                'status' => $status
            ]);
            $html = view('home.sections.header1_row', compact('item'))->render();
            broadcast(new LIneHeaderUpdated($html, 1, $item->id));
            return response()->json([1, 'ok']);
        } catch (\Exception $exception) {
            return response()->json([0, $exception->getMessage()]);
        }
    }

    public function headers(HeaderCategoryLine1 $id)
    {
        $items = $id->Headers()->orderBy('priority', 'asc')->get()->groupBy('priority');
        return view('admin.header1.index', compact('items', 'id'));
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
            $header1_categories = HeaderCategoryLine1::orderBy('priority', 'asc')->where('status', 1)->get();
            $html = view('home.sections.header1', compact('header1_categories'))->render();
            broadcast(new LIneHeaderUpdated($html, 1, null));
            return redirect()->back()->with('success', __($message));
        } catch (\Exception $exception) {

            return redirect()->back()->with('failed', __($exception->getMessage()));
        }


    }

    public function category_change_status(Request $request)
    {
        try {
            $id = $request->id;
            $status = $request->value == 'true' ? 1 : 0;
            $item = HeaderCategoryLine1::findOrFail($id);
            $item->update([
                'status' => $status
            ]);
            $header1_categories = HeaderCategoryLine1::orderBy('priority', 'asc')->where('status', 1)->get();
            $html = view('home.sections.header1', compact('header1_categories'))->render();
            broadcast(new LIneHeaderUpdated($html, 1, null));
            return response()->json([1, 'ok']);
        } catch (\Exception $exception) {
            return response()->json([0, $exception->getMessage()]);
        }
    }
}
