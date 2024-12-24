<?php

namespace App\Http\Controllers;

use App\Events\MarketIndexResult;
use App\Events\MarketStatusUpdated;
use App\Events\MarketTableIndex;
use App\Events\MarketTimeUpdated;
use App\Models\Market;
use App\Models\MarketSetting;
use App\Models\Refund;
use App\Models\Transaction;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function statusTimeMarket($market, $force_determine_status = 0)
    {
        $ready_to_duration = $market->ready_to_open;
        $open_duration = $market->opening;
        $q_1 = $market->q_1;
        $q_2 = $market->q_2;
        $q_3 = $market->q_3;
//        $endMinutes = $open_duration + $q_1 + $q_2 + $q_3 + 3;
        $date = $market->date;
        $time = $market->time;
        $date_time = $date . ' ' . $time;
        $startTime = Carbon::parse($date_time);
        $now = Carbon::now();
        $time_to_close_bid_deposit = $startTime->copy()->addMinutes(-120);

        $benchmark1 = $startTime->copy()->addMinutes(-$ready_to_duration);
        $benchmark2 = $startTime;
        $benchmark3 = $startTime->copy()->addMinutes($open_duration);
        $benchmark4 = $benchmark3->copy()->addMinutes($q_1);
        $benchmark5 = $benchmark4->copy()->addMinutes($q_2);
        $benchmark6 = $benchmark5->copy()->addMinutes($q_3);
        $bids = $market->Bids;
        if ($force_determine_status == 0) {
            if ($market->status == 7) {
                return [0, $market->status, $benchmark1, $benchmark2, $benchmark3, $benchmark4, $benchmark5, $benchmark6, $date_time, $time_to_close_bid_deposit];
            }
        }

        if ($now <= $benchmark1) {
            //normal show time
            $status = 1;
            $difference = $benchmark2->diffInSeconds($now);

        } elseif ($benchmark1 < $now and $now <= $benchmark2) {
            //ready to open
            $status = 2;
            $difference = $benchmark2->diffInSeconds($now);

        } elseif ($benchmark2 < $now and $now <= $benchmark3) {
            //open
            $status = 3;
            $difference = $benchmark3->diffInSeconds($now);

        } elseif ($benchmark3 < $now and $now <= $benchmark4) {
            //Q 1/2
            $status = 4;
            $difference = $benchmark4->diffInSeconds($now);
            //if no bid received market must be closed!
            if (count($bids) == 0) {
                $status = 7;
                $difference = 0;
            }

        } elseif ($benchmark4 < $now and $now <= $benchmark5) {
            //Q 2/2
            $status = 5;
            $difference = $benchmark5->diffInSeconds($now);
        } elseif ($benchmark5 < $now and $now <= $benchmark6) {

            //Competition
            $difference = $benchmark6->diffInSeconds($now);
            $status = 6;
            //exists min-price
//            $market_min_price = $market->offer_price;
            if ($market->SalesForm->price_type == 'Fix') {
                $market_min_price = $market->SalesForm->price;
            } else {
                $market_min_price = $market->SalesForm->alpha;
            }
            $market_min_price = intval($market_min_price) - 1;

            $bid_touch_price = $market->Bids()->Where('price', '>', $market_min_price)->get();
            if (count($bid_touch_price) < 2) {
                $status = 7;
                $difference = 0;
            }
            if ($status != 7) {
                //check if total quality < $market->quantity
                $bids_quantity = $market->Bids()->Where('price', '>', $market_min_price)->sum('quantity');
                $market_quantity = $market->SalesForm->max_quantity;
                $market_quantity = str_replace(',', '', $market_quantity);

                if ($bids_quantity > $market_quantity) {

                } else {
                    //اگر مجموع کالاهای درخواستی از کالاهای موجود کمتر بود مارکت با موفقیت به پایان میرسد
                    $status = 7;
                    $difference = 0;
                }
            }
        } else {
            //close
            $difference = 0;
            $status = 7;
        }
        $market->status = $status;
        if ($market->isDirty()) {
            $market->save();
        }
        return [$difference, $status, $benchmark1, $benchmark2, $benchmark3, $benchmark4, $benchmark5, $benchmark6, $date_time, $time_to_close_bid_deposit];
    }

    public function convertTime($seconds)
    {
        $remaining = $seconds % 60;
        $minutes = ($seconds - $remaining) / 60;
        if ($remaining < 10) {
            $remaining = '0' . $remaining;
        }
        return $minutes . ':' . $remaining;
    }

    public function StartCheck()
    {
        $create_index_timer = $this->create_index_timer();
        $timer = $create_index_timer['timer'];
        $market_status = $create_index_timer['market_status'];
//        $total_trade_value=$create_index_timer['total_trade_value'];
        $difference = $create_index_timer['difference'];
        broadcast(new MarketIndexResult($timer, $market_status, $difference));
        $this->today_market_difference();
    }

    public function SessionCheck()
    {
        DB::table('sessions')->where('user_id', null)->delete();
    }


    function create_index_timer()
    {
        $now = Carbon::now();
        $close_market = $this->close_market_today();
        $close_market = Carbon::parse($close_market);
        $yesterday = Carbon::yesterday();
        $tomorrow = Carbon::tomorrow();
        $first_market = Market::where('date', '>', $yesterday)->where('date', '<', $tomorrow)->orderby('time', 'asc')->first();
        $market_open_exists = Market::where('date', '>', $yesterday)->where('date', '<', $tomorrow)->where('status', '<', 6)->exists();
        $start_market_time = Carbon::parse('00:00');
        if ($first_market) {
            $start_market_time = Carbon::parse($first_market->time)->addMinutes(-30);
        }

        if ($start_market_time < $now and $now < $close_market) {
            $market_is_open = 1;
        } else {
            $market_is_open = 0;
        }

        if (!$market_open_exists) {
            $market_is_open = 0;
        }

        if ($market_is_open) {
            $difference = $now->diffInSeconds($close_market);
            $status_text = 'Open';
            $color = 'green';
        } else {
            $difference = 0;
            $status_text = 'Close';
            $color = '#c20000';
        }
        $timer = $this->Timer($difference, $start_market_time, $market_is_open);
        $market_status = view('home.timer.market_status', compact('status_text', 'color'))->render();


        return [
            'timer' => $timer,
            'market_status' => $market_status,
            'difference' => $difference,
            'market_is_open' => $market_is_open,
        ];
    }

    public function close_market_today()
    {
        $yesterday = Carbon::yesterday();
        $tomorrow = Carbon::tomorrow();
        $last_market = Market::where('date', '>', $yesterday)->where('date', '<', $tomorrow)->orderby('time', 'desc')->first();
        $close_market = Carbon::yesterday();
        if ($last_market) {
            $statusTimeMarket_result = $this->statusTimeMarket($last_market);
            $close_market = $statusTimeMarket_result[7];
        }
        $hours = Carbon::parse($close_market)->format('Y/m/d');
        $minute = Carbon::parse($close_market)->format('H:i:s');
        $close_market = $hours . ' ' . $minute;
        return $close_market;
    }

    function Timer($diffSeconds, $start_market_time, $market_is_open = 1)
    {
        $days = floor($diffSeconds / 86400);
        $hours = floor(($diffSeconds - ($days * 86400)) / 3600);
        $minutes = floor(($diffSeconds - ($days * 86400) - ($hours * 3600)) / 60);
        $seconds = floor(($diffSeconds - ($days * 86400) - ($hours * 3600) - ($minutes * 60)));
        if ($hours < "10") {
            $hours = "0" . $hours;
        }
        if ($minutes < "10") {
            $minutes = "0" . $minutes;
        }
        if ($seconds < "10") {
            $seconds = "0" . $seconds;
        }
        $change_time = MarketSetting::where('key', 'change_time')->pluck('value')->first();
        $change_time = Carbon::parse($change_time)->format("H:i:s");
        $now2 = Carbon::now()->format("H:i:s");
        $start_market_time = Carbon::parse($start_market_time)->format("H:i:s");

        $timer_is_red = 0;
        if ($diffSeconds == 0 and $now2 < $change_time) {
            $timer_is_red = 1;
            if ($now2 < $start_market_time) {
                $timer_is_red = 0;
            }
        }

        $midnight = Carbon::today()->format("H:i:s");
        if ($change_time < $now2 and $now2 < $midnight) {
            $timer_is_red = 1;
        }
        $yesterday = Carbon::yesterday();
        $tomorrow = Carbon::tomorrow();
        $today_market_exists = Market::where('date', '>', $yesterday)->where('date', '<', $tomorrow)->exists();
        if (!$today_market_exists) {
            $timer_is_red = 1;
        }
        if ($market_is_open == 1) {
            $timer_is_red = 0;
        }
        return view('home.timer.index', compact('hours', 'minutes', 'seconds', 'timer_is_red'))->render();
    }

    function MarketTimer($diffSeconds)
    {
        $days = floor($diffSeconds / 86400);
        $hours = floor(($diffSeconds - ($days * 86400)) / 3600);
        $minutes = floor(($diffSeconds - ($days * 86400) - ($hours * 3600)) / 60);
        $seconds = floor(($diffSeconds - ($days * 86400) - ($hours * 3600) - ($minutes * 60)));
        $extra_hour=$days*24;
        $hours=$hours+$extra_hour;
        if ($hours < "10") {
            $hours = "0" . $hours;
        }
        if ($minutes < "10") {
            $minutes = "0" . $minutes;
        }
        if ($seconds < "10") {
            $seconds = "0" . $seconds;
        }
        if ($hours == 0) {
            $timer='<div class="column">
        <div class="timer">' . $minutes . '</div>
        <div class="text">MIN</div>
    </div>
    <div style="font-family: normal !important" class="seprator">:</div>
    <div class="column">
        <div class="timer">' . $seconds . '</div>
        <div class="text">SEC</div>
    </div>';
        } else {
            $timer='<div class="column">
        <div class="timer">' . $hours . '</div>
        <div class="text">HR</div>
    </div>
    <div style="font-family:none !important" class="seprator">:</div>
    <div class="column">
        <div class="timer">' . $minutes . '</div>
        <div class="text" >MIN</div>
    </div>
    <div style="font-family: normal !important" class="seprator">:</div>
    <div class="column">
        <div class="timer">' . $seconds . '</div>
        <div class="text" >SEC</div>
    </div>';
        }
        return $timer;
    }

    public function today_market_difference()
    {
        try {
            $yesterday = Carbon::yesterday();
            $tomorrow = Carbon::tomorrow();
            $today = Carbon::today();
            $the_day_after_tomorrow = Carbon::today()->copy()->addDay(3);
            $today_markets_groups = Market::where('date', '>', $yesterday)->where('date', '<', $tomorrow)->orderby('date', 'asc')->get()->groupby('date');
            $tomorrow_markets_groups = Market::where('date', '>', $today)->where('date', '<', $the_day_after_tomorrow)->orderby('date', 'asc')->get()->groupby('date');

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
                    $market_id = $market->id;
                    $difference = $result[0];
                    $timer = $this->MarketTimer($difference);
                    $status = $market['status'];
                    $step = $market->step_price_competition;
                    broadcast(new MarketStatusUpdated($market_id, $difference, $timer, $status, $step));
                }
            }
            foreach ($tomorrow_markets_groups as $markets) {
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
                    $market_id = $market->id;
                    $difference = $result[0];
                    $timer = $this->MarketTimer($difference);
                    $status = $market['status'];
                    $step = $market->step_price_competition;
                    broadcast(new MarketStatusUpdated($market_id, $difference, $timer, $status, $step));
                }
            }

        } catch (\Exception $e) {
            return response()->json([0, $e->getMessage()]);
        }
    }

    public function check_market($id)
    {
        $market = Market::find($id);
        $result = $this->statusTimeMarket($market);
    }

    public function today_market_status()
    {
        try {
            $yesterday = Carbon::yesterday();
            $today = Carbon::today();
            $tomorrow = Carbon::tomorrow();

            $change_time = MarketSetting::where('key', 'change_time')->pluck('value')->first();
            $change_time = Carbon::parse($change_time)->format("H:i:s");
            $now = Carbon::now()->format("H:i:s");

            if ($now >= $change_time) {
                $nextThreeDays = [
    $today->copy()->addDay(1),
    $today->copy()->addDay(2),
    $today->copy()->addDay(3),
];
                $future = $today->copy()->addDay(4);
                $markets_g = Market::whereIn('date', $nextThreeDays)->orderby('date', 'asc')->get();
            } else {
                $nextThreeDays = [
                    $today,
    $today->copy()->addDay(1),
    $today->copy()->addDay(2),
    $today->copy()->addDay(3),
];
                $future = $yesterday->copy()->addDay(4);
                $markets_g = Market::whereIn('date', $nextThreeDays)->orderby('date', 'asc')->get();
            }


            $markets_groups = $markets_g->groupby('date');


            

// تاریخ‌های سه روز آینده

  

// حالا بررسی می‌کنیم که برای هر روز آیا مارکت داریم یا نه
foreach ($nextThreeDays as $index => $day) {
    $dayFormatted = $day->format('Y-m-d');
    
    // اگر مارکت برای این روز وجود ندارد، جستجو از روز 4 ام به بعد
    if (!$markets_groups->has($dayFormatted)) {
   
        $foundMarket = false;

      
        // از روز 4 ام به بعد به مدت 3 روز بررسی می‌کنیم
        for ($i = 4; $i <= 19; $i++) {
            $futureDay = $today->copy()->addDays($i); // روزهای بعد از روز 4 ام

            $futureFormatted = $futureDay->format('Y-m-d');
            
             $marketsForThisDay = Market::where('date', $futureFormatted)->get();
    
    // اگر مارکت‌ها برای این روز پیدا شدند، آن‌ها را جایگزین می‌کنیم
    if ($marketsForThisDay->isNotEmpty()) {
        
        // جایگزینی مارکت‌ها برای روز بدون مارکت
                        if (!$markets_groups->has($futureFormatted)) {
                           
                    // جایگزینی مارکت‌ها برای روز بدون مارکت
                    $markets_groups->put($futureFormatted, $marketsForThisDay);
                }
        $foundMarket = true;
        break; // اگر مارکت پیدا شد، از حلقه خارج می‌شویم
    }
        }

        // اگر مارکت پیدا نشد، عملیات یا پیام خطا
        if (!$foundMarket) {
            // می‌توانید پیام خطا را اینجا نمایش دهید
            break;
        }
    }
}

dd($markets_groups);
            
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

            $market_values = 0;
            $market_is_open = 0;

            foreach ($today_markets_groups as $markets) {
                foreach ($markets as $market) {
                    $market_status_index = $this->market_status_index($market, $market_is_open);
                    $market_is_open = $market_status_index[0];
                    $market_value = str_replace(',', '', $market->market_value);
                    $market_values = $market_values + intval($market_value);

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
                    $market_id = $market->id;
                    $difference = $result[0];
                    $timer = $this->MarketTimer($difference);
                    $status = $market['status'];
                    $step = $market->step_price_competition;
                    broadcast(new MarketStatusUpdated($market_id, $difference, $timer, $status, $step));
                }
            }

            $change_time = MarketSetting::where('key', 'change_time')->pluck('value')->first();
            $change_time = Carbon::parse($change_time)->format("H:i:s");
            $now2 = Carbon::now()->format("H:i:s");
            $midnight = Carbon::tomorrow()->format("H:i:s");

            $market_values_html = '$' . number_format($market_values);
            $create_index_timer = $this->create_index_timer();
            $market_is_open = $create_index_timer['market_is_open'];

            $timer_and_value_color = $this->timer_and_value_color($market_is_open, $market_values);
            $color = $timer_and_value_color['color'];
            $show_market_value = $timer_and_value_color['show_market_value'];


            $market_values_html = '<span style="color: ' . $color . '">' . $market_values_html . '</span>';

            $now = Carbon::now();
            $is_login = auth()->check();
            $view_table = view('home.partials.market', compact('markets_groups', 'now', 'is_login'))->render();
            broadcast(new MarketTableIndex($view_table, $market_values_html, $show_market_value));
        } catch (\Exception $e) {
            dd($e->getMessage());
            return response()->json([0, $e->getMessage()]);
        }
    }

    public function market_status_index($market, $market_is_open)
    {
        if ($market->status != 7) {
            $market_is_open = 1;
        }
        return [$market_is_open];
    }

    public function calculate_user_wallet($user)
    {
        $transactions = $user->Transactions();
        $wallet = 0;
        foreach ($transactions as $transaction) {
            $type = $transaction->type;
            $i = $type == 1 ? 1 : -1;
            $wallet = $wallet + ($i * $transaction->amount);
        }
        return $wallet;
    }

    public function refund(Request $request)
    {
        $user_id = $request->user_id;
        $amount = $request->amount;
        try {
            Refund::create([
                'user_id' => $user_id,
                'amount' => $amount
            ]);
            return response()->json([1, 'ok']);
        } catch (\Exception $e) {
            return response()->json([0, $e->getMessage()]);
        }

    }

    public function timer_and_value_color($market_is_open, $market_values)
    {
        $show_market_value = 1;
        $yesterday = Carbon::yesterday();
        $tomorrow = Carbon::tomorrow();
        $first_market = Market::where('date', '>', $yesterday)->where('date', '<', $tomorrow)->orderby('time', 'asc')->first();
        $start_market_time = Carbon::parse('00:00:00')->format("H:i:s");
        $change_time = MarketSetting::where('key', 'change_time')->pluck('value')->first();
        $change_time = Carbon::parse($change_time)->format("H:i:s");
        $now = Carbon::now()->format("H:i:s");
        //


        //
        //
        if ($first_market) {
            $start_market_time = Carbon::parse($first_market->time)->addMinutes(-30)->format("H:i:s");
        }

        if ($now < $start_market_time) {
            $color = '#006';

        } else {
            if ($now < $change_time) {
                if ($market_is_open == 1) {
                    $color = '#006';
                } else {
                    $color = '#c20000';
                }
            } else {
                $show_market_value = 0;
                $color = '#006';
            }
        }

        if ($market_values < 0) {
            $show_market_value = 0;
        }
        return [
            'color' => $color,
            'show_market_value' => $show_market_value,
        ];

    }

}
