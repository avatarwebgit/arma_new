<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Models\wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index(User $user)
    {
        $wallet = $this->calculate_user_wallet($user);
        $transactions = Transaction::where('user_id',$user->id)->latest()->get();
        return view('admin.wallets.index', compact('wallet', 'user', 'transactions'));
    }

    public function wallet_change(Request $request)
    {
        try {
            $user_id = $request->user_id;
            $type = $request->type;
            $amount = $request->amount;
            $description = $request->description;
            Transaction::create([
                'user_id' => $user_id,
                'type' => $type,
                'amount' => $amount,
                'status' => 1,
                'description' => $description,
            ]);
            session()->flash('success', 'wallet change successfully');
            return response()->json([1]);
        } catch (\Exception $e) {
            dd($e->getMessage());
            session()->flash('error', $e->getMessage());
            return response()->json([1]);
        }
    }
}
