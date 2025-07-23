<h1>Transaction Successful</h1>
<em>{{ $transaction->created_at }}</em>

<table border="1">
    <tr>
        <th>Subsciber Number</th>
        <th>Nominal</th>
        <th>Method</th>
        <th>Status</th>
        @if ($transaction->voucher)
            <th>Voucher</th>
        @endif
    </tr>
    <tr>
        <td>{{ $transaction->subscriber_number }}</td>
        <td>{{ $transaction->total }}</td>
        <td>{{ $transaction->method }}</td>
        <td>{{ $transaction->status }}</td>
        @if ($transaction->voucher)
            <td>{{ $transaction->voucher }}</td>
        @endif
    </tr>
</table>
