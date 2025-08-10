<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Facades\App\Services\TransactionReport;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithProperties;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat\Wizard\Number;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat\Wizard\Currency;

class FilmTicketTransactionsExport implements FromView, ShouldAutoSize, WithEvents, WithProperties
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        return view("report-table", [
            "service" => "film-ticket",
            "reports" => TransactionReport::getReport("film-ticket")
        ]);
    }

    public function registerEvents(): array
    {
        return [
            BeforeWriting::class => function (BeforeWriting $event) {
                $event
                    ->getWriter()
                    ->getDelegate()
                    ->getActiveSheet()
                    ->getPageSetup()
                    ->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
            },
            AfterSheet::class => function (AfterSheet $afterSheet) {
                $rupiahCurrencyMask = new Currency(
                    "Rp",
                    2,
                    Number::WITH_THOUSANDS_SEPARATOR,
                    Currency::LEADING_SYMBOL,
                    Currency::SYMBOL_WITHOUT_SPACING
                );

                $afterSheet->sheet->formatColumn("D", $rupiahCurrencyMask);

                $afterSheet->sheet->formatColumn("G", $rupiahCurrencyMask);
            },
        ];
    }

    public function properties(): array
    {
        return [
            "creator" => Auth::user()->name,
            "title" => "Film Ticket Transaction Report"
        ];
    }
}
