<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\OrderExcelCreator;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MarketExport implements FromCollection, WithHeadings, WithColumnWidths
{
    public $markets;

    public function __construct($markets)
    {
        $this->markets = $markets;
    }

    public function collection()
    {
        $items = [];
        $markets = $this->markets;

        foreach ($markets as $market) {
            $bid = $market->Bids()->orderBy('price', 'desc')->first();
            $has_winner = $market->Bids()->where('is_win', 1)->exists();

            // تنظیم رنگ و متن وضعیت
            $status_color = $has_winner ? 'green' : 'red';
            $status_text = $has_winner ? 'Done' : 'Failed';

            // تنظیم واحد
            $unit = ($market->SalesForm->unit == 'other' || $market->SalesForm->unit == 'Other')
                ? $market->SalesForm->unit_other
                : $market->SalesForm->unit;

            // تنظیم ارز
            $currency = ($market->SalesForm->currency == 'other' || $market->SalesForm->currency == 'Other')
                ? $market->SalesForm->currency_other . '/' . $unit
                : $market->SalesForm->currency . '/' . $unit;

            // بالاترین قیمت و مقدار در صورت وجود
            $highest = $bid ? number_format($bid->price) . ' ' . $currency : 0;
            $quantity = $bid ? number_format($bid->quantity) . ' ' . $unit : 0;

            // حداقل مقدار
            $minQuantity = str_replace(',', '', $market->SalesForm->min_order);

            if ($market->SalesForm->price_type == 'Fix') {
                $price = number_format($market->SalesForm->price) . ' ' . $currency;
            } else {
                $price = number_format($market->SalesForm->alpha) . ' ' . $currency;
            }

            $highest == 0 ? 'N.A' : $highest;
            if ($highest == 0) {
                $highest = 'n/a';
            }
            if ($quantity == 0) {
                $quantity = 'n/a';
            }


            // افزودن اطلاعات به آیتم‌ها
            $items[] = [
                $market->date,
                $market->SalesForm->commodity,
                $market->SalesForm->max_quantity . ' ' . $unit,
                number_format($minQuantity) . ' ' . $unit,
                $market->SalesForm->packing,
                $market->SalesForm->incoterms,
                $market->SalesForm->origin_country,
                $market->SalesForm->price_type,
                $price,
                $highest,
                $quantity,
                $status_text,
            ];
        }

        return collect($items);
    }


    public function columnWidths(): array
    {

        return [
            'A' => 10,
            'B' => 15,
            'C' => 20,
            'D' => 15,
            'E' => 15,
            'F' => 15,
            'G' => 15,
            'H' => 20,
            'I' => 50,
            'J' => 20,
            'K' => 20,
            'L' => 20,
        ];
    }

    public function headings(): array
    {
        return [
            "Data",
            "Commodity",
            "Quantity",
            "Min Order",
            "Packing",
            "Delivery",
            "Region",
            "Price Type",
            "Offer Price",
            "Highest Bid",
            "Quantity Bid",
            "Status",
        ];
    }
}
