<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\ContainerType;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Destination;
use App\Models\FlexiTankType;
use App\Models\FormStatus;
use App\Models\HeaderCategory;
use App\Models\HeaderCurencies;
use App\Models\InspectionPlace;
use App\Models\Market;
use App\Models\MarketSetting;
use App\Models\Menus;
use App\Models\Message;
use App\Models\Packing;
use App\Models\Page;
use App\Models\PlatFom;
use App\Models\QualityQuantityInspector;
use App\Models\RefundStatus;
use App\Models\ShippingTerm;
use App\Models\TargetMarket;
use App\Models\THCIncluded;
use App\Models\ToleranceWeightBy;
use App\Models\Transaction;
use App\Models\Units;
use App\Models\UserNews;
use App\Models\UserStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MongoDB\Driver\Session;

class IndexController extends Controller
{
    public function index()
    {
//        $form_status = FormStatus::where('id', 1)->first();
//        $form_status->update([
//            'title' => 'Waiting'
//        ]);
//        $form_status = FormStatus::where('title', 'preparation')->first();
//        if (!$form_status) {
//            FormStatus::create([
//                'id' => 6,
//                'title' => 'preparation',
//            ]);
//        }
        $is_logged_in = 0;
        $is_logged_in = session()->exists('is_logged_in');
        session()->forget('is_logged_in');
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
                'now',
                'is_logged_in'
            ));
    }

    public function search(Request $request)
    {
        $value = $request->search;
        $blogs = Blog::where('title', 'LIKE', '%' . $value . '%')->orWhere('short_description', 'LIKE', '%' . $value . '%')->orWhere('description', 'LIKE', '%' . $value . '%')->get();
        $pages = Page::where('title', 'LIKE', '%' . $value . '%')->orWhere('description', 'LIKE', '%' . $value . '%')->get();
        return view('home.search', compact('value', 'pages', 'blogs'));
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
            $market_is_open_text = '<span>Market: </span><span style="color: #c20000">Close</span>';
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
        dd('nooooo');
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

        $items = Currency::all();
        foreach ($items as $item) {
            $item->delete();
        }

        $currencies = ['USD-US Dollar', 'EUR - Euro', 'GBP – British Pond', 'CAD-Canadian Dollar', 'AUD-Australian Dollar', 'JPY Japanese Yen', 'INR Indian Rupee',
            'RUB Russian Ruble', 'SGD-Singapore Dollar', 'HKD-Hong king Dollar', 'CNY-Chinese Yuan', 'BRL-Brazilian Real', 'AED-Emirati Dirham', 'KRW South Korean Won',
            'EGP-Egyptian Pound', 'TRY-Turkish Lira', 'SAR-Saudi Arabian Riyal', 'PKR-Pakistani Rupee', 'IQD-Iraqi Dinar', 'KWD- Kuwaiti Dinar', 'OMR-Omani Rial', 'QAR-Qatari Riyal',
            'IRR-Iranian Rial', 'MZN-Mozambican Metical', 'LYD-Libyan Dinar', 'UZS-Uzbekistani Som', 'TMT-Turkmenistani Manat', 'AFN-Afghan Afghani', 'AZN-Azerbaijan Manat', 'GHS-Ghanaian Cedi',
            'VES-Venezuelan Bolivar', 'BCH-Bitcoin Cash', 'ETH-Ethereum', 'T-Tether', 'Other'
        ];
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
            'L',
            'Bbl',
            'Gal',
            'M',
            'M3',
            'Cm3',
            'Kg',
            'Gr',
            'Other'
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
    public function create_user_status()
    {
        $items = UserStatus::all();
        foreach ($items as $item) {
            $item->delete();
        }
        $items = ['Index', 'Registering', 'Confirmed', 'Reject'];
        foreach ($items as $key => $item) {
            Packing::create([
                'id' => $key,
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
        $items = ['Discharge port', 'On Board Vessel', 'Factory Warehouse', 'Load Port'];
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
        $items = ['Skype', 'WatsApp', 'Telegram', 'X (Twitter)', 'LinkedIn', 'Meet',
            'WeChat'];
        foreach ($items as $key => $item) {
            PlatFom::create([
                'id' => $key + 1,
                'title' => $item
            ]);
        }

        dd('Congratulations');
    }

    public function header_category()
    {
        $items = HeaderCategory::all();
        foreach ($items as $item) {
            $item->delete();
        }
        $items = ['Urea', 'Sulphur', 'NPK', 'Phosphate'];
        foreach ($items as $key => $item) {
            HeaderCategory::create([
                'id' => $key + 1,
                'title' => $item
            ]);
        }

        dd('Congratulations');
    }

    public function header_currency()
    {
        $items = HeaderCurencies::all();
        foreach ($items as $item) {
            $item->delete();
        }
        $items = ['USD/St', 'USD/Mt', 'Euro/Mt'];
        foreach ($items as $key => $item) {
            HeaderCurencies::create([
                'id' => $key + 1,
                'title' => $item
            ]);
        }
        dd('Congratulations');
    }

    public function Container_Type()
    {
        $items = ContainerType::all();
        foreach ($items as $item) {
            $item->delete();
        }
        $items = ['20 ft', '40 ft'];
        foreach ($items as $key => $item) {
            ContainerType::create([
                'id' => $key + 1,
                'title' => $item
            ]);
        }
        dd('Congratulations');
    }

    public function Flexi_tank()
    {
        $items = FlexiTankType::all();
        foreach ($items as $item) {
            $item->delete();
        }
        $items = ['20 ft', '40 ft'];
        foreach ($items as $key => $item) {
            FlexiTankType::create([
                'id' => $key + 1,
                'title' => $item
            ]);
        }
        dd('Congratulations');
    }

    public function THC_Included()
    {
        $items = THCIncluded::all();
        foreach ($items as $item) {
            $item->delete();
        }
        $items = ['Yes', 'No'];
        foreach ($items as $key => $item) {
            THCIncluded::create([
                'id' => $key + 1,
                'title' => $item
            ]);
        }
        dd('Congratulations');
    }

    public function TargetMarket()
    {
        $items = TargetMarket::all();
        foreach ($items as $item) {
            $item->delete();
        }
        $items = ['Export Market', 'Domestic Market Market', 'Export and Domestic Market'];
        foreach ($items as $key => $item) {
            TargetMarket::create([
                'id' => $key + 1,
                'title' => $item
            ]);
        }
        dd('Congratulations');
    }

    public function Destination()
    {
        $items = Destination::all();
        foreach ($items as $item) {
            $item->delete();
        }
        $items = ['Open', 'Exclude Some Countries', 'Exclusively Countries'];
        foreach ($items as $key => $item) {
            Destination::create([
                'id' => $key + 1,
                'title' => $item
            ]);
        }
        dd('Congratulations');
    }


    public function market_more_info(Request $request)
    {
        $market_id = $request->market_id;
        $market = Market::where('id', $market_id)->first();
        $html = view('home.partials.market_more', compact('market'))->render();
        return response()->json([1, $html]);
    }

    public function market_status_update()
    {
        $items = RefundStatus::all();
        foreach ($items as $item) {
            $item->delete();
        }
        $items = ['Requested', 'Pending', 'Done'];
        foreach ($items as $key => $item) {
            RefundStatus::create([
                'id' => $key + 1,
                'title' => $item
            ]);
        }
        dd('Congratulations');
    }

}
