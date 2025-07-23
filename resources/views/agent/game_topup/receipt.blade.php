<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Game Top Up</title>
</head>

<body>
    <em>{{ $transaction->created_at }}</em>
    <h1>You have bought top up package :</h1>
    <table>
        <tr>
            <td>Game</td>
            <td>:</td>
            <td>{{ $package->game->name }}</td>
        </tr>
        <tr>
            <td>Title</td>
            <td>:</td>
            <td>{{ $package->title }}</td>
        </tr>
        <tr>
            <td>Items</td>
            <td>:</td>
            <td>{{ $package->items_count }}</td>
        </tr>
        <tr>
            <td>Price</td>
            <td>:</td>
            <td>{{ $transaction->total }}</td>
        </tr>
        <tr>
            <td>Method</td>
            <td>:</td>
            <td>{{ $transaction->method }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>:</td>
            <td>{{ $transaction->status }}</td>
        </tr>
        @if ($transaction->voucher)
            <tr>
                <td>Voucher</td>
                <td>:</td>
                <td>{{ $transaction->voucher }}</td>
            </tr>
        @endif
    </table>
</body>

</html>
