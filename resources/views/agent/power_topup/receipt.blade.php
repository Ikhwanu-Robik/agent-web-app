<h1>Transaction Successful</h1>
<em>{{ $transaction->created_at }}</em>

<table>
    <tr>
        <th>Subsciber Number</th>
        <th>Nominal</th>
        <th>Method</th>
        <th>Status</th>
    </tr>
    <tr>
        <td>{{ $transaction->subscriber_number }}</td>
        <td>{{ $transaction->total }}</td>
        <td>{{ $transaction->method }}</td>
        <td>{{ $transaction->status }}</td>
    </tr>
</table>