<?php

namespace App\Http\Controllers;

use App\Events\MarketIndexResult;
use App\Events\MarketStatusUpdated;
use App\Events\MarketTimeUpdated;
use App\Models\Market;
use App\Models\MarketSetting;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function statusTimeMarket($market, $force_determine_status = 0)
    {
        $ready_to_duration = MarketSetting::where('key', 'ready_to_open')->pluck('value')->first();
        $open_duration = MarketSetting::where('key', 'opening')->pluck('value')->first();
        $q_1 = MarketSetting::where('key', 'q_1')->pluck('value')->first();
        $q_2 = MarketSetting::where('key', 'q_2')->pluck('value')->first();
        $q_3 = MarketSetting::where('key', 'q_3')->pluck('value')->first();
        $endMinutes = $open_duration + $q_1 + $q_2 + $q_3 + 3;
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
            $difference = $benchmark1->diffInSeconds($now);

        } elseif ($benchmark1 < $now and $now <= $benchmark2) {
            //ready to open
            $status = 2;
            $difference = $benchmark2->diffInSeconds($now);

        } elseif ($benchmark2 < $now and $now <= $benchmark3) {
            //open
            $status = 3;
            $difference = $benchmark3->diffInSeconds($now);

        } elseif ($benchmark3 < $now and $now <= $benchmark4) {
            //open(1/3)
            $status = 4;
            $difference = $benchmark4->diffInSeconds($now);
            //if no bid received market must be closed!
            if (count($bids) == 0) {
                $status = 7;
                $difference = 0;
            }
            //exists min-price
//            $bid_touch_price = $market->Bids()->where('price', '>=', $market->min_price)->exists();
            $bid_touch_price = true;
            if (!$bid_touch_price) {
                $status = 7;
                $difference = 0;
            }

        } elseif ($benchmark4 < $now and $now <= $benchmark5) {
            //open(2/3)
            $status = 5;
            $difference = $benchmark5->diffInSeconds($now);

        } elseif ($benchmark5 < $now and $now <= $benchmark6) {
            //open(3/3)
            $difference = $benchmark6->diffInSeconds($now);
            $status = 6;
            //check if total quality < $market->quantity
            $bids_quantity = $market->Bids()->sum('quantity');
            $market_quantity = $market->quantity;
            if ($bids_quantity <= $market_quantity) {
                $status = 7;
                $difference = 0;
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
//        broadcast(new MarketStatusUpdated($market->id,$difference));
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

    function create_index_timer()
    {
        $now = Carbon::now();
        $close_market = $this->close_market_today();
        $close_market = Carbon::parse($close_market);
        if ($now < $close_market) {
            $difference = $now->diffInSeconds($close_market);
            $status_text = 'Open';
        } else {
            $difference = 0;
            $status_text = 'Close';
        }

        $timer = $this->Timer($difference);
        $market_status = view('home.timer.market_status', compact('status_text'))->render();

        return [
            'timer' => $timer,
            'market_status' => $market_status,
            'difference' => $difference,
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

    function Timer($diffSeconds)
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
        return view('home.timer.index', compact('hours', 'minutes', 'seconds'))->render();
    }

    function MarketTimer($diffSeconds)
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
        return $hours . ':' . $minutes . ':' . $seconds;
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
