<?php

namespace App\Http\Controllers\Home;

use App\Events\TestEvent;
use App\Http\Controllers\Controller;
use App\Models\Market;
use App\Models\MarketSetting;
use App\Models\Message;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class IndexController extends Controller
{
    public function index()
    {
        $get_change_time_exists=MarketSetting::where('key','change_time')->exists();
        if (!$get_change_time_exists){
            MarketSetting::create([
                'key' => 'change_time',
                'value' => '12:00:00',
            ]);
        }
        $UserRegistered = session()->exists('UserRegistered');
        session()->forget('UserRegistered');
        $UserRegistered_message = Message::where('type', 'UserRegistered')->first();

        $market_open_finished_modal_exists = session()->exists('market_open_finished');
        if ($market_open_finished_modal_exists) {
            $market_open_finished_modal_exists = 1;
        } else {
            $market_open_finished_modal_exists = 0;
        }
        $market_open_finished_modal = '';
        if ($market_open_finished_modal_exists) {
            $market_open_finished_modal = session()->get('market_open_finished');
        }
        session()->forget('market_open_finished');

        return view('home.index.index',
            compact('UserRegistered',
                'UserRegistered_message',
                'market_open_finished_modal_exists',
                'market_open_finished_modal'));
    }

    public function home()
    {
        dd('okkk');
    }

    public function MarketTableIndex()
    {
        try {
            $change_time = MarketSetting::where('key', 'change_time')->pluck('value')->first();
            $yesterday=Carbon::yesterday();
            $pre_yesterday = Carbon::yesterday()->copy()->addDay(-1);
            $today = Carbon::today();
            $tomorrow=Carbon::tomorrow();
            $future = $yesterday->copy()->addDay(4);
            $yesterday_markets_groups = Market::where('date', '>', $pre_yesterday)->where('date', '<', $today)->where('time','>',$change_time)->orderby('date','asc')->get()->groupby('date');
            $markets_groups = Market::where('date', '>', $yesterday)->where('date', '<', $future)->orderby('date','asc')->get()->groupby('date');
            $ids = [];
            foreach ($markets_groups as $markets) {
                foreach ($markets as $market) {
                    $result = $this->statusTimeMarket($market);
                    $market['difference'] = $result[0];
                    $market['status'] = $result[1];
                    $market['benchmark1'] = $result[2];
                    $market['benchmark2'] = $result[3];
                    $market['benchmark3'] = $result[4];
                    $market['benchmark4'] = $result[5];
                    $market['benchmark5'] = $result[6];
                    $market['benchmark6'] = $result[7];
                    $market['date_time'] = $result[8];
                    $ids[] = $market->id;
                }
            }
            foreach ($yesterday_markets_groups as $markets) {
                foreach ($markets as $market) {
                    $result = $this->statusTimeMarket($market);
                    $market['difference'] = $result[0];
                    $market['status'] = $result[1];
                    $market['benchmark1'] = $result[2];
                    $market['benchmark2'] = $result[3];
                    $market['benchmark3'] = $result[4];
                    $market['benchmark4'] = $result[5];
                    $market['benchmark5'] = $result[6];
                    $market['benchmark6'] = $result[7];
                    $market['date_time'] = $result[8];
                    $ids[] = $market->id;
                }
            }
            $view_table = view('home.partials.market', compact('markets_groups','yesterday_markets_groups'))->render();

            return response()->json([1, $view_table, $ids]);
        } catch (\Exception $e) {
            return response()->json([0, $e->getMessage()]);
        }

    }

    public function redirectUser()
    {
        $user_check = auth()->check();
        if ($user_check) {
            $user = auth()->user();
            if ($user->hasRole(['admin'])) {
                return redirect()->route('admin.dashboard');
            }
            if ($user->hasRole(['seller'])) {
                return redirect()->route('seller.dashboard');
            }
            if ($user->hasRole(['buyer'])) {
                return redirect()->route('bidder.dashboard');
            }
        } else {
            return redirect()->route('home.index');
        }
    }

    public function startBroadCast()
    {
        $message = ['name' => 'reza', 'family' => 'Arabi'];
        broadcast(new \App\Events\TestEvent($message));

    }
}
