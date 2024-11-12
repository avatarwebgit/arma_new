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
            //
            $bid = $market->Bids()->orderBy('price', 'desc')->first();

            $has_winner = $market->Bids()->where('is_win', 1)->exists();
            if ($has_winner) {
                $status_color = 'green';
                $status_text = 'Done';
            } else {
                $status_color = 'red';
                $status_text = 'Failed';
            }
            if ($market->SalesForm->unit == 'other' or $market->SalesForm->unit == 'Other') {
                $unit = $market->SalesForm->unit_other;
            } else {
                $unit = $market->SalesForm->unit;
            }
            if ($market->SalesForm->currency == 'other' or $market->SalesForm->currency == 'Other') {
                $currency = $market->SalesForm->currency_other . '/' . $unit;
            } else {
                $currency = $market->SalesForm->currency . '/' . $unit;
            }

            if ($bid) {

                $highest = $bid->price . ' ' . $currency;
                $quantity = $bid->quantity . ' ' . $unit;
            } else {
                $highest = 0;
                $quantity = 0;
            }
            //
            $minQuantity = str_replace(',', '', $market->SalesForm->min_order);

            $items['Data'] = $market->date;
            $items['Commodity'] = $market->SalesForm->commodity;
            $items['Quantity'] = $market->SalesForm->max_quantity . ' ' . $unit;
            $items['Min Order'] = number_format($minQuantity) . ' ' . $unit;
            $items['Packing'] = $market->SalesForm->packing;
            $items['Delivery'] = $market->SalesForm->packing;
        }
        dd($items);
        return $items;
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
            "Quantity",
            "Status",
        ];
    }
}
