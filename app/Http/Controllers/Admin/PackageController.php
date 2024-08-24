<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Header1;
use App\Models\Packing;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $items = Packing::OrderBy('title', 'asc')->get();
        return view('admin.packages.index', compact('items'));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:packing,title'
        ]);
        try {
            Packing::create([
                'title' => $request->title,
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

    public function edit(Packing $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, Packing $package)
    {
        $request->validate([
            'title' => 'required|unique:packing,title,' . $package->id
        ]);

        try {
            $package->update([
                'title' => $request->title,
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
            $package = Packing::where('id', $id)->first();
            $package->delete();
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
