<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Market;
use App\Models\SalesOfferForm;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $roleCounts = [
            'all' => User::all()->count(),
            'sellers' => User::where('active_status', 2)->where('active', 1)->whereHas('roles', function ($query) {
                $query->where('name', 'seller');
            })->count(),
            'buyers' => User::where('active_status', 2)->where('active', 1)->whereHas('roles', function ($query) {
                $query->where('name', 'buyer');
            })->count(),
            'members' => User::where('active_status', 2)->where('active', 1)->whereHas('roles', function ($query) {
                $query->where('name', 'Members');
            })->count(),
            'representatives' => User::where('active_status', 2)->where('active', 1)->whereHas('roles', function ($query) {
                $query->where('name', 'Representatives');
            })->count(),
            'brokers' => User::where('active_status', 2)->where('active', 1)->whereHas('roles', function ($query) {
                $query->where('name', 'Brokers');
            })->count(),
        ];
        $inquiryCounts = [
            'inbox' => SalesOfferForm::where('status', 1)->whereNotNull('form_id')->where('used_in_market', 0)->count(),
            'cash_pending' => SalesOfferForm::where('status', 2)->where('form_id', '!=', null)->where('used_in_market', 0)->count(),
            'data_pending' => SalesOfferForm::where('status', 3)->where('form_id', '!=', null)->where('used_in_market', 0)->count(),
            'rejected' => SalesOfferForm::where('status', 4)->where('form_id', '!=', null)->where('used_in_market', 0)->count(),
            'approved' => SalesOfferForm::where('status', 5)->where('form_id', '!=', null)->where('used_in_market', 0)->count(),
            'preparation' => SalesOfferForm::where('status', 6)->where('form_id', '!=', null)->where('used_in_market', 0)->count(),
        ];
        $market_count = Market::all()->groupBy('date')->count();
        $SalesFormCounts = [
            'Save' => SalesOfferForm::where('user_id', \auth()->id())->where('is_save', 1)->count(),
            'Draft' => SalesOfferForm::where('user_id', \auth()->id())->where('is_save', 2)->count(),
        ];
        $yesterday = Carbon::yesterday()->format('Y-m-d');
        $group_markets = Market::where('date', '=', $yesterday)
            ->orWhere('date', '>', $yesterday)
            ->orderBy('date', 'asc')
            ->get()
            ->groupBy('date')
            ->take(5);
        $latest_markets = Market::orderBy('date', 'asc')
            ->get()
            ->take(10);
        $commodities = [];
        $bids = [];
        foreach ($latest_markets as $key=>$item){
            $commodities[]=$item->SalesForm->commodity;
            $bids[]=count($item->Bids);
        }
        return view('admin.dashboard.dashboard', compact(
            'roleCounts',
            'inquiryCounts',
            'market_count',
            'SalesFormCounts',
            'group_markets',
            'latest_markets',
            'commodities',
            'bids',
        ));
    }
}
