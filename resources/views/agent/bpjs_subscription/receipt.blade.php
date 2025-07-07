@php
    $bpjs = session('bpjs');
    $form_input = session('form_input');
    $transaction = session('transaction');
@endphp

@if ($bpjs)
    <h1>Transaction Successful</h1>
    <em>{{ $transaction->created_at }}</em>

    <h2>Bayar BPJS untuk {{ $transaction->month_bought }} Bulan</h2>

    <h3>Data terbaru BPJS-mu</h3>

    <table border="1">
        <tr>
            <th>NIK</th>
            <th>Aktif sampai</th>
        </tr>
        <tr>
            <td>{{ $bpjs->civilInformation->NIK }}</td>
            <td>{{ $bpjs->dueDate() }}</td>
        </tr>
    </table>

    Total pembayaran <b>Rp.{{ number_format($transaction->total, 0, '.') }}</b>
    <br>
    Metode pembayaran <b>{{ $transaction->method }}</b>
@else
    Oops, it seems there's no transaction data here
@endif
