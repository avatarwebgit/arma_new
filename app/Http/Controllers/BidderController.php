<?php

namespace App\Http\Controllers;

use App\Models\SalesOfferForm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BidderController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $wallets = $user->wallets;
        return view('bidder.dashboard', compact('user', 'wallets'));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('bidder.profile', compact('user'));
    }

    public function updateProfile(User $user, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'company_name' => 'required',
            'field' => 'required',
            'mobile_number' => 'required',
        ]);
        $user->update($request->except('new_password'));
        if ($request->has('new_password')) {
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);
        }
        session()->flash('success', 'User Updated Successfully');
        return redirect()->back();
    }

    public function requests()
    {
        $id = auth()->id();
        $items = SalesOfferForm::where('user_id', $id)->where('is_complete', 1)->paginate();
        return view('bidder.sales_form.list', compact('items'));
    }
}
