<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\CargoInsurance;
use App\Models\CompanyType;
use App\Models\ContainerType;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Destination;
use App\Models\FlexiTankType;
use App\Models\Incoterms;
use App\Models\IncotermsVersion;
use App\Models\InspectionPlace;
use App\Models\Packing;
use App\Models\PaymentTerm;
use App\Models\PriceType;
use App\Models\QualityQuantityInspector;
use App\Models\SalesOfferForm;
use App\Models\ShippingTerm;
use App\Models\TargetMarket;
use App\Models\THCIncluded;
use App\Models\ToleranceWeightBy;
use App\Models\Units;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $wallets = $user->wallets;
        return view('home.profile.index',compact('user','wallets'));
    }
    public function profile()
    {
        $user = auth()->user();
        return view('home.profile.index',compact('user'));
    }
    public function updateProfile(User $user,Request $request)
    {
        $request->validate([
            'name' =>'required',

        ]);
        $user->update([
            'name' =>$request->name,
        ]);
        if ($request->has('password')){
            $user->update([
                'password' =>Hash::make($request->password),
            ]);
        }
        session()->flash('success', 'Update Successfully');
        return redirect()->back();

    }
    public function updatePassword(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'password' =>'required',

        ]);
        if ($request->has('password')){
            $user->update([
                'password' =>Hash::make($request->password),
            ]);
        }
        session()->flash('success', 'Update Successfully');
        return redirect()->back();
    }
    public function requests()
    {
        $id = auth()->id();
        $items = SalesOfferForm::where('user_id', $id)->where('is_complete', 1)->paginate();
        return view('seller.sales_form.list', compact('items'));
    }

}
