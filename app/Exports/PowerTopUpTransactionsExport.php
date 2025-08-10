<?php

namespace App\Exports;

use App\Facades\TransactionReport;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat\Wizard\Number;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat\Wizard\Currency;

class PowerTopUpTransactionsExport implements FromView, ShouldAutoSize, WithEvents
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        return view("report-table", [
            "service" => "power-top-up",
            "reports" => TransactionReport::getReport("power-top-up")
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $afterSheet) {
                $rupiahCurrencyMask = new Currency(
                    "Rp",
                    2,
                    Number::WITH_THOUSANDS_SEPARATOR,
                    Currency::LEADING_SYMBOL,
                    Currency::SYMBOL_WITHOUT_SPACING
                );

                $afterSheet->sheet->formatColumn("B", $rupiahCurrencyMask);
            },
        ];
    }
}
