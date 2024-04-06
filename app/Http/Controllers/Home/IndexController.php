<?php

namespace App\Http\Controllers\Home;

use App\Events\TestEvent;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Currency;
use App\Models\Market;
use App\Models\MarketSetting;
use App\Models\Menus;
use App\Models\Message;
use App\Models\Setting;
use App\Models\Units;
use App\Models\User;
use App\Models\UserNews;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class IndexController extends Controller
{
    public function index()
    {
        $get_change_time_exists = MarketSetting::where('key', 'change_time')->exists();
        if (!$get_change_time_exists) {
            MarketSetting::create([
                'key' => 'change_time',
                'value' => '12:00:00',
            ]);
        }
        $modal_message=[];
        $show_modal=0;
        //message for Registered
        $UserRegistered = session()->exists('UserRegistered');
        if ($UserRegistered){
            $show_modal=1;
            session()->forget('UserRegistered');
            $modal_message = Message::where('type', 'UserRegistered')->first();
        }

        //message for User Is Deactivate
        $user_inactive = session()->exists('user_inactive');
        if ($user_inactive){
            $show_modal=1;
            session()->forget('user_inactive');
            $modal_message = Message::where('type', 'user_inactive')->first();
        }



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
            compact('market_open_finished_modal_exists',
                'market_open_finished_modal',
            'show_modal',
            'modal_message',
            ));
    }

    public function home()
    {
        dd('okkk');
    }

    public function MarketTableIndex()
    {
        try {

            $change_time = MarketSetting::where('key', 'change_time')->pluck('value')->first();
            $yesterday = Carbon::yesterday();
            $pre_yesterday = Carbon::yesterday()->copy()->addDay(-1);
            $today = Carbon::today();
            $tomorrow = Carbon::tomorrow();
            $future = $yesterday->copy()->addDay(4);
            $yesterday_markets_groups = Market::where('date', '>', $pre_yesterday)->where('date', '<', $today)->where('time', '>', $change_time)->orderby('date', 'asc')->get()->groupby('date');
            $markets_groups = Market::where('date', '>', $yesterday)->where('date', '<', $future)->orderby('date', 'asc')->get()->groupby('date');
            $today_markets_groups = Market::where('date', '>', $yesterday)->where('date', '<', $tomorrow)->orderby('date', 'asc')->get()->groupby('date');
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
            $market_values = 0;
            $market_is_open = 0;
            foreach ($today_markets_groups as $markets) {
                foreach ($markets as $market) {
                    if ($market->status != 7) {
                        $market_is_open = 1;
                    }
                    $market_values = $market_values + $market->offer_price;
                }
            }
            if ($market_is_open === 1) {
                $market_is_open_text = '<span>Market: </span><span class="text-success">Open</span>';
            } else {
                $market_is_open_text = '<span>Market: </span><span class="text-danger">Close</span>';
            }
            $now=Carbon::now();
            $view_table = view('home.partials.market', compact('markets_groups', 'yesterday_markets_groups','now'))->render();
            return response()->json([1, $view_table, $ids, number_format($market_values), $market_is_open_text]);
        } catch (\Exception $e) {
            return response()->json([0, $e->getMessage()]);
        }

    }

    public function redirectUser()
    {
        $user_check = auth()->check();
        if ($user_check) {
            $user = auth()->user();
            if ($user->active_status==0){
                auth()->logout();
                session()->put('user_inactive',1);
                return redirect()->route('home.index');
            }
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

    public function menus(Menus $menus)
    {
        $page = $menus->Pages()->first();
        return view('home.page', compact('page','menus'));
    }


    public function blogs()
    {
        $blogs = Blog::all();
        return view('home.blog.index',compact('blogs'));
    }
    public function blog_show(Blog $blog)
    {

        return view('home.blog.show',compact('blog'));
    }
    public function join_news(Request $request)
    {

        UserNews::create([
            'email'=>$request->email
        ]);
        session()->flash('success', 'Join has been Successfully');
        return redirect()->route('home.index');

    }
}
