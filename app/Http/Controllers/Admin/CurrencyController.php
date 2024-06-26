<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Header1;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index()
    {
        $currencies = Currency::OrderBy('title', 'asc')->get();
        return view('admin.currencies.index', compact('currencies'));
    }

    public function create()
    {
        return view('admin.currencies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image',
            'title' => 'required|unique:currencies,title'
        ]);

        try {
            if ($request->has('image')) {

                $env = env('UPLOAD_IMAGE_CURRENCY');
                $image = generateFileName($request->image->getClientOriginalName());
                $request->image->move(public_path($env), $image);
            } else {
                $image = null;
            }
            Currency::create([
                'title' => $request->title,
                'image' => $image
            ]);
            $type = 'success';
            $msg = 'The Item Has Been Created Successfully';

        } catch (\Exception $exception) {
            $type = 'failed';
            $msg = $exception->getMessage();
        }
        session()->flash($type, $msg);
        return redirect()->back();
    }

    public function edit(Currency $currency)
    {
        return view('admin.currencies.edit', compact('currency'));
    }

    public function update(Request $request, Currency $currency)
    {
        $request->validate([
            'image' => 'nullable|image',
            'title' => 'required|unique:currencies,title,' . $currency->id
        ]);

        try {
            if ($request->has('image')) {
                $path = public_path(env('UPLOAD_IMAGE_CURRENCY') . $currency->image);
                if (file_exists($path) and !is_dir($path)){
                    unlink($path);
                }

                $env = env('UPLOAD_IMAGE_CURRENCY');
                $image = generateFileName($request->image->getClientOriginalName());
                $request->image->move(public_path($env), $image);
            } else {
                $image = $currency->image;
            }
            $currency->update([
                'title' => $request->title,
                'image' => $image
            ]);
            $type = 'success';
            $msg = 'The Item was Updated Successfully';

        } catch (\Exception $exception) {
            $type = 'failed';
            $msg = $exception->getMessage();
        }
        session()->flash($type, $msg);
        return redirect()->back();
    }

    public function remove($id)
    {

        try {
            $currency = Currency::where('id', $id)->first();
            $path = public_path(env('UPLOAD_IMAGE_CURRENCY') . $currency->image);
            if (file_exists($path) and !is_dir($path)){
                unlink($path);
            }
            $currency->delete();
            $type = 'success';
            $msg = 'The Item Has Been Deleted Successfully';

        } catch (\Exception $exception) {
            $type = 'failed';
            $msg = $exception->getMessage();
        }
        session()->flash($type, $msg);
        return redirect()->back();
    }
}
