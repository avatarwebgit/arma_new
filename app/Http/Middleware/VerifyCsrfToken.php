<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    protected $except = [
        'forms/fill/*',
        '/paytm-callback*',
        '/get_market_bit_result',
        '/MarketTableIndex',
        '/get_market_bit_result',
        '/refreshBidTable',
        '/refreshSellerTable',
        '/change_market_status',
        '/get_market_info',
        '/Market_Table_Index_Status',
        '/check_market_status_for_continue',
        '/pay_bid_deposit',
        '/login',
    ];
}
