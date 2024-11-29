<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Header1;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        $items = Country::OrderBy('countryName', 'asc')->get();
        return view('admin.countries.index', compact('items'));
    }

    public function create()
    {
        return view('admin.countries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'countryName' => 'required|unique:countries,countryName',
            'telephonePrefix'=>'required',
        ]);

        try {
            Country::create([
                'countryName' => $request->countryName,
                'telephonePrefix' => $request->telephonePrefix,
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

    public function edit(Country $country)
    {
        return view('admin.countries.edit', compact('country'));
    }

    public function update(Request $request,Country $country)
    {
        $request->validate([
            'countryName' => 'required|unique:countries,countryName,' . $country->id,
            'telephonePrefix'=>'required'
        ]);

        try {
            $country->update([
                'countryName' => $request->countryName,
                'telephonePrefix' => $request->telephonePrefix,
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
            $country = Country::where('id', $id)->first();

            $country->delete();
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
