<h1>Transaction {{ $transaction->method == "cash" ? "Successful" : "Pending" }}</h1>
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

@if ($transaction->method == 'flip')
    <h3>To pay with Flip, click <a href="{{ 'https://' . $flip_response['link_url'] }}">this link</a></h3>
@endif
