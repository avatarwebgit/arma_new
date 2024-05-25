<?php

namespace App\Http\Controllers\Home;

use App\Events\MarketStatusUpdated;
use App\Events\MarketTableIndex;
use App\Events\TestEvent;
use App\Events\MarketIndexResult;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Country;
use App\Models\Currency;
use App\Models\FormStatus;
use App\Models\InspectionPlace;
use App\Models\Market;
use App\Models\MarketSetting;
use App\Models\Menus;
use App\Models\Message;
use App\Models\Packing;
use App\Models\PlatFom;
use App\Models\QualityQuantityInspector;
use App\Models\Setting;
use App\Models\ShippingTerm;
use App\Models\ToleranceWeightBy;
use App\Models\Units;
use App\Models\User;
use App\Models\UserNews;
use Carbon\Carbon;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use function Symfony\Component\String\b;

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
        $modal_message = [];
        $show_modal = 0;
        //message for Registered
        $UserRegistered = session()->exists('UserRegistered');
        if ($UserRegistered) {
            $show_modal = 1;
            session()->forget('UserRegistered');
            $modal_message = Message::where('type', 'UserRegistered')->first();
        }

        //message for User Is Deactivate
        $user_inactive = session()->exists('user_inactive');
        if ($user_inactive) {
            $show_modal = 1;
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
        $close_market = $this->close_market_today();
        $close_market = Carbon::parse($close_market);
        $now = Carbon::now();
        session()->forget('market_open_finished');
        return view('home.index.index',
            compact('market_open_finished_modal_exists',
                'market_open_finished_modal',
                'show_modal',
                'modal_message',
                'close_market',
                'now'
            ));
    }

    public function home()
    {
        dd('okkk');
    }


    public function Market_Table_Index_Status()
    {
        $yesterday = Carbon::yesterday();
        $tomorrow = Carbon::tomorrow();
        $markets = Market::where('date', '>', $yesterday)->where('date', '<', $tomorrow)->orderby('date', 'asc')->get();
        $market_is_open = 0;
        foreach ($markets as $market) {
            $market_status_index = $this->market_status_index($market, $market_is_open);
            $market_is_open = $market_status_index[0];
        }
        if ($market_is_open === 1) {
            $market_is_open_text = '<span>Market: </span><span class="text-success">Open</span>';
        } else {
            $market_is_open_text = '<span>Market: </span><span class="text-danger">Close</span>';
        }
        $close_market = $this->close_market_today();
        $close_market = Carbon::parse($close_market);
        $now = Carbon::now();

        return response()->json([1, $market_is_open_text, $close_market, $market_is_open, $now]);
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
                    $market_status_index = $this->market_status_index($market, $market_is_open);
                    $market_is_open = $market_status_index[0];
                    $market_values = $market_values + $market->market_value;
                }
            }
            if ($market_is_open === 1) {
                $market_is_open_text = '<span>Market: </span><span class="text-success">Open</span>';
            } else {
                $market_is_open_text = '<span>Market: </span><span class="text-danger">Close</span>';
            }
            $close_market = $this->close_market_today();
            $close_market = Carbon::parse($close_market);
            $now = Carbon::now();
            $view_table = view('home.partials.market', compact('markets_groups', 'yesterday_markets_groups', 'now'))->render();
            return response()->json([1, $view_table, $ids, number_format($market_values), $market_is_open_text, $close_market, $market_is_open, $now]);
        } catch (\Exception $e) {
            return response()->json([0, $e->getMessage()]);
        }
    }

    function market_status_index($market, $market_is_open)
    {
        if ($market->status != 7) {
            $market_is_open = 1;
        }
        return [$market_is_open];
    }

    public function redirectUser()
    {
        $user_check = auth()->check();
        if ($user_check) {
            $user = auth()->user();
            if ($user->active_status == 0) {
                auth()->logout();
                session()->put('user_inactive', 1);
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
        return view('home.page', compact('page', 'menus'));
    }


    public function blogs()
    {
        $blogs = Blog::all();
        return view('home.blog.index', compact('blogs'));
    }

    public function blog_show(Blog $blog)
    {

        return view('home.blog.show', compact('blog'));
    }

    public function join_news(Request $request)
    {

        UserNews::create([
            'email' => $request->email
        ]);
        session()->flash('success', 'Join has been Successfully');
        return redirect()->route('home.index');

    }


    public function create_countries()
    {
        $countries = [
            'United States', 'Singapore', 'South Africa',
            'China', 'Austria', 'Slovenia', 'Tajikistan',
            'Russia', 'Nigeria', 'Ghana', 'Kyrgyzstan',
            'India', 'United Arab Emirates', 'Myanmar',
            'France', 'Vietnam', 'Jordan',
            'Germany', 'Malaysia', 'Cameroon', 'Somalia',
            'United Kingdom', 'Philippines', 'Latvia', 'Montenegro',
            'Japan', 'Bangladesh', 'Sudan', 'South Sudan',
            'Saudi Arabia', 'Denmark', 'Libya',
            'Italy', 'South Africa', 'Bolivia',
            'Israel', 'Hong Kong', 'Bahrain',
            'Canada', 'Egypt',
            'Brazil', 'Pakistan', 'Nepal',
            'Australia', 'Iran', 'Estonia',
            'Spain', 'Chile', 'Macau', 'South Korea', 'Romania', 'El Salvador',
            'Netherlands', 'Colombia', 'Honduras',
            'Turkey', 'Czech Republic', 'Djibouti',
            'Switzerland', 'Finland', 'Senegal',
            'Taiwan', 'Peru',
            'Mexico', 'Iraq',
            'Poland', 'Portugal', 'Zimbabwe',
            'Argentina', 'New Zealand', 'Zambia',
            'Belgium', 'Kazakhstan', 'Iceland',
            'Sweden', 'Greece', 'Bosnia and Herzegovina',
            'Ireland', 'Qatar', 'Pakistan',
            'Thailand', 'Azerbaijan',
            'Norway', 'DR Congo',
        ];
        $items = Country::all();
        foreach ($items as $item) {
            $item->delete();
        }
        foreach ($countries as $key => $country) {
            Country::create([
                'id' => $key + 1,
                'title' => $country
            ]);
        }

        dd('Congratulations');

    }

    public function create_currencies()
    {
        $currencies = [
            'U.S.Dollar',
            'Euro',
            'Japanese Yen',
            'British Pound',
            'Swiss Franc',
            'Canadian Dollar',
            'Australian/N.Z. Dollar',
            'South African Rand',
            'Derham',
            'Turkey Lir',
            'Omani Rial',
            'Kuwaiti Dinar',
            'other'
        ];
        $items = Currency::all();
        foreach ($items as $item) {
            $item->delete();
        }
        foreach ($currencies as $key => $currency) {
            Currency::create([
                'id' => $key + 1,
                'title' => $currency
            ]);
        }

        dd('Congratulations');
    }

    public function create_units()
    {
        $units = [
            'Mt',
            'St',
            'Kg',
            'Barrel',
            'Gallon',
            'Lb',
            'other'
        ];
        $items = Units::all();
        foreach ($items as $item) {
            $item->delete();
        }
        foreach ($units as $key => $unit) {
            Units::create([
                'id' => $key + 1,
                'title' => $unit
            ]);
        }

        dd('Congratulations');
    }

    public function tolerance_wight_by()
    {

        $items = ToleranceWeightBy::all();
        foreach ($items as $item) {
            $item->delete();
        }
        $items = ['Seller', 'Buyer'];
        foreach ($items as $key => $item) {
            ToleranceWeightBy::create([
                'id' => $key + 1,
                'title' => $item
            ]);
        }

        dd('Congratulations');
    }

    public function create_packing()
    {
        $items = Packing::all();
        foreach ($items as $item) {
            $item->delete();
        }
        $items = ['25 kg Bag', '50 kg Bag', 'Bulk', 'Drum', 'Flexi Tank', 'Jumbo Bag', 'other'];
        foreach ($items as $key => $item) {
            Packing::create([
                'id' => $key + 1,
                'title' => $item
            ]);
        }

        dd('Congratulations');
    }

    public function shipping_term()
    {
        $items = ShippingTerm::all();
        foreach ($items as $item) {
            $item->delete();
        }
        $items = ['FSHEX', 'SHEXFHEEX', 'SSHEX', 'FHINC', 'SSHINC', 'SHEX UU', 'SSHEX UU '];
        foreach ($items as $key => $item) {
            ShippingTerm::create([
                'id' => $key + 1,
                'title' => $item
            ]);
        }

        dd('Congratulations');
    }

    public function quality_quantity_inspector()
    {
        $items = QualityQuantityInspector::all();
        foreach ($items as $item) {
            $item->delete();
        }
        $items = ['seller', 'buyer', 'jointly seller and buyer'];
        foreach ($items as $key => $item) {
            QualityQuantityInspector::create([
                'id' => $key + 1,
                'title' => $item
            ]);
        }

        dd('Congratulations');
    }

    public function InspectionPlace()
    {
        $items = InspectionPlace::all();
        foreach ($items as $item) {
            $item->delete();
        }
        $items = ['discharge port', 'on board vessel', 'factory warehouse', 'load port'];
        foreach ($items as $key => $item) {
            InspectionPlace::create([
                'id' => $key + 1,
                'title' => $item
            ]);
        }

        dd('Congratulations');
    }

    public function Platforms()
    {
        $items = PlatFom::all();
        foreach ($items as $item) {
            $item->delete();
        }
        $items = ['Skype', 'WatsApp', 'Telegram', 'X (Twitter)', 'LinkedIn'];
        foreach ($items as $key => $item) {
            PlatFom::create([
                'id' => $key + 1,
                'title' => $item
            ]);
        }

        dd('Congratulations');
    }



    public function today_market_status()
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
                    $market_status_index = $this->market_status_index($market, $market_is_open);
                    $market_is_open = $market_status_index[0];
                    $market_values = $market_values + $market->market_value;

                    //
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
                    $market_id=$market->id;
                    $difference=$result[0];
                    broadcast(new MarketStatusUpdated($market_id,$difference));
                }
            }
            if ($market_is_open === 1) {
                $market_is_open_text = '<span>Market: </span><span class="text-success">Open</span>';
            } else {
                $market_is_open_text = '<span>Market: </span><span class="text-danger">Close</span>';
            }
            $close_market = $this->close_market_today();
            $close_market = Carbon::parse($close_market);
            $now = Carbon::now();
            $view_table = view('home.partials.market', compact('markets_groups', 'yesterday_markets_groups', 'now'))->render();
            broadcast(new MarketTableIndex($view_table));
            $this->today_market_difference();
        } catch (\Exception $e) {
            return response()->json([0, $e->getMessage()]);
        }
    }
    public function today_market_difference()
    {
        try {
            $yesterday = Carbon::yesterday();
            $tomorrow = Carbon::tomorrow();
            $today_markets_groups = Market::where('date', '>', $yesterday)->where('date', '<', $tomorrow)->orderby('date', 'asc')->get()->groupby('date');
            foreach ($today_markets_groups as $markets) {
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
                    $market_id=$market->id;
                    $difference=$result[0];
                    $timer = $this->MarketTimer($difference);
                    broadcast(new MarketStatusUpdated($market_id,$difference,$timer));
                }
            }

        } catch (\Exception $e) {
            return response()->json([0, $e->getMessage()]);
        }
    }


}
