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
        return $this->markets;
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
            'M' => 20,
            'N' => 20,
            'O' => 20,
            'P' => 20,
            'Q' => 20,
            'R' => 20,
            'S' => 20,
        ];
    }

    public function headings(): array
    {
        return [
            "row_id",
            "order_id",
            "شماره سفارش",
            "تاریخ سفارش",
            "نام و نام خانوادگی مشتری",
            "موبایل مشتری",
            "کدملی مشتری",
            "تلفن مشتری",
            "سفارشات",
            "قیمت واحد کالا(تومان)",
            "اقلام همراه",
            "قیمت اقلام همراه",
            "تعداد",
            "جمع هر مدل کالا(تومان)",
            "مبلغ سفارش(تومان)",
            "هزینه حمل",
            "آدرس مشتری",
        ];
    }
}
