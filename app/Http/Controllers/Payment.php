<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Payment extends Controller
{
    public function pay_bid_deposit(Request $request)
    {
        $payment_type = $request->payment_type;
        if ($payment_type==1){
            //Online
        }
        if ($payment_type==2){
            //Wallet
        }
        if ($payment_type==3){
            //Cash
        }
        if ($payment_type==4){
            //Account
        }
    }
}
