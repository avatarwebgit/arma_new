<?php

namespace App\Http\Controllers\Home;

use App\Events\ChangeSaleOffer;
use App\Events\MarketStatusUpdated;
use App\Events\NewBidCreated;
use App\Events\TestEvent;
use App\Http\Controllers\Controller;
use App\Models\BidHistory;
use App\Models\Market;
use App\Models\MarketSetting;
use App\Models\MarketStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function Symfony\Component\Translation\t;

class MarketHomeController extends Controller
{
    public function bid(Market $market)
    {
        if (!auth()->check()) {
            session()->flash('Login', 'Please login');
            return redirect()->route('home.index');
        }
        $market_status = $market->status;
//        if ($market_status == 4 or $market_status == 5 or $market_status == 6 ) {
//            session()->flash('market_open_finished','You Just Enter The Market When Is Open');
//            return redirect()->route('home.index');
//        }
        $result = $this->statusTimeMarket($market);
        $market['difference'] = $result[0];
        $market['status'] = $result[1];
        $market['benchmark1'] = $result[2];
        $market['benchmark2'] = $result[3];
        $market['benchmark3'] = $result[4];
        $market['benchmark4'] = $result[5];
        $market['benchmark5'] = $result[6];
        $market['benchmark6'] = $result[7];
        $market['time_to_close_bid_deposit'] = $result[9];
        $bids = $market->Bids()->orderBy('price', 'desc')->take(10)->get();
        $bid_deposit_text_area = MarketSetting::where('key', 'bid_deposit_text_area')->pluck('value')->first();
        $term_conditions = MarketSetting::where('key', 'term_conditions')->pluck('value')->first();
        return view('home.market.index', compact('market', 'bids', 'bid_deposit_text_area', 'term_conditions'));
    }

    public function GetMarket(Request $request)
    {
        $market_id = $request->market_id;
        $market = Market::where('id', $market_id)->first();
        $result = $this->statusTimeMarket($market);
        $market['difference'] = $result[0];
        $market['status'] = $result[1];
        $market['benchmark1'] = $result[2];
        $market['benchmark2'] = $result[3];
        $market['benchmark3'] = $result[4];
        $market['benchmark4'] = $result[5];
        $market['benchmark5'] = $result[6];
        $market['benchmark6'] = $result[7];

        $difference = $market['difference'];
        $now = time();
        $now = Carbon::parse($now);
        $view = view('home.market.benchmark_info', compact('market'))->render();
        return response()->json([1, $view, $now, $difference]);
    }

    public function refreshMarketTable()
    {
        $ready_to_duration = MarketSetting::where('key', 'ready_to_duration')->pluck('value')->first();
        $open_duration = MarketSetting::where('key', 'open_duration')->pluck('value')->first();
        $q_1 = MarketSetting::where('key', 'q_1')->pluck('value')->first();
        $q_2 = MarketSetting::where('key', 'q_2')->pluck('value')->first();
        $q_3 = MarketSetting::where('key', 'q_3')->pluck('value')->first();
        $endMinutes = $open_duration + $q_1 + $q_2 + $q_3 + 3;
        try {
            $markets = Market::where('start', '>', Carbon::yesterday())->orderBy('start', 'asc')->get();
            foreach ($markets as $market) {
                $this->statusTimeMarket($market, $ready_to_duration, $open_duration, $q_1, $q_2, $q_3);
            }
            $view = view('home.partials.market', compact('markets'))->render();
            return response()->json([1, $view]);
        } catch (\Exception $e) {
            return response()->json([0, $e->getMessage()]);
        }
    }

    public function refreshMarket(Request $request)
    {
        $market = Market::where('id', $request->market)->first();
        $result = $this->statusTimeMarket($market);
        $time = $this->convertTime($result[0]);
        $market = Market::where('id', $request->market)->first();
        $market_is_open = 1;
        $market_status = $market->status;
        if ($market_status == 1 or $market_status == 2 or $market_status == 7) {
            $market_is_open = 0;
        }

        return response()->json([1, $market->Status->title, $time, $market->Status->color, $market_is_open]);
    }

    public function refreshBidTable(Request $request)
    {
        $market = Market::where('id', $request->market)->first();
        $ids = $this->BidWinner($market);
        $bids = [];
        foreach ($ids as $key => $id) {
            $bid = BidHistory::where('id', $id)->first();
            $bids[] = $bid;
        }
        $view = view('home.market.bidder_table', compact('bids'))->render();
        return response()->json([1, $view]);
    }

    public function refreshSellerTable(Request $request)
    {
        $market = Market::find($request->market);
        $view = view('home.market.seller_table', compact('market'))->render();
        return response()->json([1, $view]);
    }

    public function change_market_status(Request $request)
    {
        try {
            $market_id = $request->market_id;
            $status = $request->status;
            $market = Market::where('id', $market_id)->first();
            if ($request->status > 3) {

                $bids = $market->Bids;
                if (count($bids) == 0) {
                    $status = 7;
                }
            }
            if ($market->status == 5) {
                $market->update([
                    'pre_status' => 5,
                ]);
            }
            $market->update([
                'status' => $status
            ]);


            return response()->json($status);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function check_market_status_for_continue(Request $request)
    {
        try {
            $market_id = $request->market_id;
            $status = $request->status;
            $market = Market::find($market_id);
            $price = $market->offer_price;
            $max_quantity = $market->SalesForm->max_quantity;
            if ($status === 4) {
                $base_price = $price / 2;
                $bids = $market->Bids()->where('price', '>=', $base_price)->get();
                if (count($bids) > 0) {
                    return response()->json([1, 'continue']);
                }
                $market->update([
                    'status' => 7
                ]);
                return response()->json([1, 'close']);
            }

            if ($status == 6) {

                $bids_touch_price = $market->Bids()->where('price', '>=', $price)->get();
                if (count($bids_touch_price) == 0) {
                    $market->update([
                        'status' => 7
                    ]);
                    return response()->json([1, 'close']);
                }
                $total_quantity = 0;
                foreach ($bids_touch_price as $bid) {
                    $total_quantity = $total_quantity + $bid->quantity;
                }
                $max_quantity = $market->SalesForm->max_quantity;
                if ($total_quantity < $max_quantity or $total_quantity == $max_quantity) {
                    $market->update([
                        'status' => 7
                    ]);
                    return response()->json([1, 'close']);
                }

//                $bids_exists_count = $market->Bids()->where('price', '>=', $price)->count();
//                if ($bids_exists_count < 2) {
//                    $market->update([
//                        'status' => 7
//                    ]);
//                    return response()->json([1, 'close']);
//                }
            }

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function seller_change_offer(Request $request)
    {
        try {
            $user_id = auth()->id();
            $price = $request->price;
//            $quantity = $request->quantity;
            $market_id = $request->market_id;
            $market = Market::where('id', $market_id)->first();
            $status = $market->status;
            $currency = $market->SalesForm->currency;
//            if ($user_id != $market->user_id) {
//                return response()->json([1, 'error', 'You Do Not Have Permission To Change Offer']);
//            }
//            if ($status == '4') {
//                //quotation 1/2
//                $pre_max_quantity = $market->SalesForm->max_quantity;
//                if ($quantity <= $pre_max_quantity) {
//                    return response()->json([1, 'error', 'Just You Can Increase Quantity']);
//                }
//                $market->SalesForm()->update(['max_quantity' => $quantity]);
//            }
            if ($status == '5') {
                //quotation 2/2
                $pre_price = $market->offer_price;
                $highest_price_exists = $market->Bids()->Orderby('price', 'desc')->exists();
                if ($highest_price_exists) {
                    $highest = $market->Bids()->Orderby('price', 'desc')->first();
                    $highest_price = $highest->price;
                    if ($price < $highest_price) {
                        return response()->json([1, 'error', 'Minimum Price You Can Enter is: ' . $highest_price . ' ' . $currency]);
                    }
                    if ($price > $pre_price) {
                        return response()->json([1, 'error', 'Maximum Price You Can Enter is: ' . $pre_price . ' ' . $currency]);
                    }
//                    $market->update(['offer_price' => $price]);
                    $market->SalesForm()->update(['price' => $price]);
                }
            }
            broadcast(new ChangeSaleOffer($market->id));
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function bid_market(Request $request)
    {
        $market = Market::find($request->market);
        if ($market->status == 6) {
            $validator = $request->validate([
                'price' => 'required',
            ]);
            $best_bid_exists = $market->Bids()->where('user_id', auth()->id())->orderBy('price', 'asc')->exists();
            if ($best_bid_exists) {
                $best_bid = $market->Bids()->where('user_id', auth()->id())->orderBy('price', 'asc')->first();
                $request['quantity'] = $best_bid->quantity;
            } else {
                $message = 'You Cannot Permission To Bid Because You Didnot Enter Any Bid In Previous Level';
                return ['alert', 'error', $message];
            }
        } else {
            $validator = $request->validate([
                'price' => 'required',
                'quantity' => 'required',
            ]);

        }
//        $price = $market->offer_price;
        $price = $market->SalesForm->price;
        $min_order = $market->SalesForm->min_order;
        $max_quantity = $market->SalesForm->max_quantity;
        $unit = $market->SalesForm->unit;

        $currency = $market->SalesForm->currency;
        $base_price = $price / 2;


        try {
            $bid_permission = $this->Bid_Permissions();

            if ($bid_permission['response'] === 'error') {
                return response()->json([$bid_permission['response'], $bid_permission['message']]);
            }

            $Opening_roles = $this->Opening_roles($request->all(), $min_order, $max_quantity, $unit, $currency, $base_price, $price, $market);

            if (!$Opening_roles[0]) {
                $error_type = $Opening_roles['validate_error'];
                $key = $Opening_roles['key'];
                $message = $Opening_roles['message'];
                return response()->json([$error_type, $key, $message]);
            }
            $pre_user_bid = $market->Bids()->where('user_id', auth()->id())->first();
            if ($pre_user_bid) {
                $tries = $pre_user_bid->tries + 1;
                $pre_user_bid->delete();
            } else {
                $tries = 1;
            }


            BidHistory::create([
                'user_id' => auth()->id(),
                'market_id' => $request->market,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'tries' => $tries,
            ]);
            broadcast(new NewBidCreated($request->market));
            return response()->json([1, 'success']);
        } catch (\Exception $e) {
            return response()->json([0, 'error']);
        }
    }

    public function remove_bid(Request $request)
    {
        try {
            $bid_id = $request->bid_id;
            $bid = BidHistory::where('id', $bid_id,)->where('user_id', auth()->id())->first();
            $market_id = $bid->market_id;
            $bid->delete();
            broadcast(new NewBidCreated($market_id));
        } catch (\Exception $e) {
            dd($e->getMessage());
        }


    }

    function Opening_roles($request, $min_order, $max_quantity, $unit, $currency, $base_price, $price, $market)
    {
        $max_bid=$market->Bids()->order('price','desc')->first();
        dd($max_bid);
        if ($max_bid){
            $base_price=$max_bid->price;
        }
        if ($request['price'] < $base_price) {
            $key = 'price';
            $message = 'min price you can enter is: ' . $base_price . ' ' . $currency;
            return [0 => false, 'validate_error' => 'price_quantity', 'key' => $key, 'message' => $message];
        }
        if ($market->status !== 6) {
            if ($request['price'] > $price) {
                $key = 'price';
                $message = 'Max price you can enter is: ' . $price . ' ' . $currency;
                return [0 => false, 'validate_error' => 'price_quantity', 'key' => $key, 'message' => $message];
            }
        }
        if (intval($request['quantity']) > intval($max_quantity)) {
            $key = 'quantity';
            $message = 'Max quantity you can enter is: ' . $max_quantity . ' ' . $unit;
            return [0 => false, 'validate_error' => 'price_quantity', 'key' => $key, 'message' => $message];
        }

//        if ($request['quantity'] < $min_order) {
//            $key = 'quantity';
//            $message = 'Min quantity you can enter is: ' . $min_order . ' ' . $unit;
//            return [0 => false, 'validate_error' => 'price_quantity', 'key' => $key, 'message' => $message];
//        }

        if ($market->status === 3) {
            $user_bids = $market->Bids()->where('user_id', auth()->id())->where('tries', 3)->get();
            if (count($user_bids) > 0) {
                $key = 'bid number';
                $message = 'Maximum number You Can Bid is: 3';
                return [0 => false, 'validate_error' => 'alert', 'key' => $key, 'message' => $message];
            }
        }

        if ($request['quantity'] < $min_order) {
            $key = 'quantity';
            $message = 'Min quantity you can enter is: ' . $min_order . ' ' . $unit;
            return [0 => false, 'validate_error' => 'price_quantity', 'key' => $key, 'message' => $message];
        }


        if (in_array($market->status, array(4, 5))) {
            $best_bid = $market->Bids()->max('price');
            if ($request['price'] < $best_bid) {
                $key = 'bid number';
                $message = 'قیمتت کمه';
                return [0 => false, 'validate_error' => 'alert', 'key' => $key, 'message' => $message];
            }
        }

        $this_my_bid_exists = $market->Bids()->where('price', $request['price'])->where('quantity', $request['quantity'])->where('user_id', auth()->id())->exists();
        if ($this_my_bid_exists) {
            $key = 'bid_exists';
            $message = 'Please enter different Bid';
            return [0 => false, 'validate_error' => 'alert', 'key' => $key, 'message' => $message];
        }

        if ($market->status == 6) {
            $market_step = $market->step_price_competition;
            $best_bid_price = $market->Bids()->orderBy('price', 'desc')->first()->price;
            $min_price_acceptable = $best_bid_price + $market_step;
            if (intval($request['price']) < $min_price_acceptable) {
                $key = 'price_step';
                $message = 'min price you can enter is: ' . $min_price_acceptable;
                return [0 => false, 'validate_error' => 'alert', 'key' => $key, 'message' => $message];
            }
        }

        //اگر کاربر در مرحله ی opening هیچ بیدی نذاشته بود نمیتواند در مراحل بعدی بید بزند
        $user_has_bid_exists = $market->Bids()->where('user_id', auth()->id())->exists();
        if ($market->status != 3 and $market->status != 2 and $market->status != 1 and $market->status != 0) {
            if (!$user_has_bid_exists) {
                $key = 'error';
                $message = 'چون شما در مرحله ی opening هیچ بیدی نذاشته اید نمیتوانید وارد رقابت شوید';
                return [0 => false, 'validate_error' => 'alert', 'key' => $key, 'message' => $message];
            }
        }

        $bid_exists = $market->Bids()->exists();
        if ($bid_exists) {
            $highest_price_exists = $market->Bids()->where('user_id', auth()->id())->exists();
            if ($highest_price_exists) {
                $highest_price = $market->Bids()->where('user_id', auth()->id())->orderBy('price', 'desc')->first();
                $highest_price = $highest_price->price;
                if ($request['price'] < $highest_price) {
                    $key = 'highest_price';
                    $message = 'Your New Bid Must Better Than Previous!';
                    return [0 => false, 'validate_error' => 'alert', 'key' => $key, 'message' => $message];
                }
                if ($request['price'] == $highest_price) {
                    $highest_price = $market->Bids()->where('user_id', auth()->id())->orderBy('price', 'desc')->first();
                    if (!in_array($market->status, array(4, 5))) {
                        if ($request['quantity'] < $highest_price->quantity) {
                            $key = 'highest_price';
                            $message = 'Your New Bid Must Better Than Previous!';
                            return [0 => false, 'validate_error' => 'alert', 'key' => $key, 'message' => $message];
                        }
                    }
                }
            }
        }

        return [0 => true];
    }

    public function Bid_Permissions()
    {
        //            //user must login
        if (!auth()->check()) {
            $msg = 'You must Login!';
            return ['response' => 'error', 'message' => $msg];
        }
//            //user must bidder
        if (auth()->user()->hasRole('seller')) {
            $msg = 'You must Buyer!';
            return ['response' => 'error', 'message' => $msg];
        }
        //user can bid
        $user = auth()->user();
        if ($user->can_bid === 0) {
            $msg = 'You Do not have permission to Bid!';
            return ['response' => 'error', 'message' => $msg];
        }
        return ['response' => true, 'message' => 'success'];
    }

    public function get_market_bit_result(Request $request)
    {
        try {
            $market_id = $request->id;
            $market = Market::where('id', $market_id)->first();
            $bidhistories_groups = $market->Bids()->orderby('price', 'desc')->get()->groupby('price');
            $ids = $this->BidWinner($market);
            $bids = [];
            $max_quantity = str_replace(',', '', $market->SalesForm->max_quantity);
            $remain_quantity = $max_quantity;
            $win_user_ids = [];
            foreach ($ids as $key => $id) {
                $is_win = 1;
                //calculate remain quantity

                $bid = BidHistory::where('id', $id)->first();
                $bid_quantity = $bid->quantity;
                if ($remain_quantity == 0) {
                    $quantity_win = 0;
                } else {
                    if ($remain_quantity > $bid_quantity) {
                        $quantity_win = $bid_quantity;
                        $remain_quantity = $remain_quantity - $bid_quantity;
                    } else {
                        $quantity_win = $remain_quantity;
                        $remain_quantity = 0;
                    }
                }

//                $price = $market->offer_price;
                $price = $market->SalesForm->price;
//                $best_bid = $market->Bids()->max('price');
//                $is_win = 1;
//                if ($best_bid == $price) {
//                    if ($bid->price == $best_bid) {
//                        $quantites = $market->Bids()->where('price', $best_bid)->get();
//                        $quantites = $quantites->sum('quantity');
//                        $count_price = $market->Bids()->where('price', $best_bid)->count();
//
//                        if ($count_price > 1) {
//                            if ($max_quantity == $quantites) {
//                                $is_win = 1;
//                            } else {
//                                $is_win = 0;
//                            }
//                        } else {
//                            $is_win = 1;
//                        }
//                    }
//                }


                //اگر تعداد کالا کمتر از مینیموم باشد بید بازنده است
                if ($quantity_win < $market->SalesForm->min_order) {
                    $is_win = 0;
                }
                //در هر صورتی اگر قیمت را تاچ نکرد بازنده است
                if ($bid->price < $price) {
                    $is_win = 0;
                }

                if ($is_win == 1) {
                    $win_user_ids[] = $bid->user_id;
                }


                $bid->update([
                    'quantity_win' => $quantity_win,
                    'is_win' => $is_win,
                ]);


                $bids[] = $bid;

            }

            $view = view('home.market.final_status', compact('bids', 'market'))->render();
            $user_is_login = auth()->check();
            $id_exists_in_array = 0;
            $show_win_modal = 0;
            if ($user_is_login) {
                $user_login_id = auth()->id();
                $id_exists_in_array = in_array($user_login_id, $win_user_ids);
            }
            if ($id_exists_in_array == 1) {
                $show_win_modal = 1;
            }
            return response()->json([1, $view, $show_win_modal]);
        } catch (\Exception $exception) {
            return response()->json([0, $exception->getMessage()]);
        }

    }

    public function get_market_info(Request $request)
    {
        try {
            $market_is_open = 0;
            $market_id = $request->market_id;
            $market = Market::where('id', $market_id)->first();
            $status_text = $market->Status->title;
            $status_color = $market->Status->color;
            if ($market->status == 2 or $market->status == 3 or $market->status == 4 or $market->status == 5 or $market->status == 6 or $market->status == 7) {
                $market_is_open = 1;
            }
            return response()->json([1, $status_text, $status_color, $market_is_open]);
        } catch (\Exception $exception) {
            return response()->json([0, $exception->getMessage()]);
        }

    }

    public function BidWinner($market)
    {
        $sort_ids = [];
        $bidhistories_groups = $market->Bids()->orderby('price', 'desc')->get()->groupby('price');
        foreach ($bidhistories_groups as $bidhistories) {
            $bidhistories_qroupedby_quantities = $bidhistories->sortByDesc('quantity')->groupby('quantity');
            foreach ($bidhistories_qroupedby_quantities as $key => $bidhistories_qroupedby_quantity) {
                foreach ($bidhistories_qroupedby_quantity->sortBy('created_at', false) as $item) {
                    $sort_ids[] = $item->id;
                }
            }
        }
        return $sort_ids;
    }
}
