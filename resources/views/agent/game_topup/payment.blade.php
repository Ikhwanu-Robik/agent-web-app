<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Game Top Up</title>
</head>

<body>
    <h1>You're about to buy top up package :</h1>
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
            <td>{{ $package->price }}</td>
        </tr>
    </table>

    <form action="{{ "/game/topup/package/" . $package->id . "/pay" }}" method="post">
        @csrf
        <label for="payment_method">payment_method</label>
        <select name="payment_method" id="payment_method">
            <option value="cash">cash</option>
            <option value="flip">flip</option>
        </select>
        <label for="voucher">voucher</label>
        <select name="voucher" id="voucher">
            <option value="-1">no voucher</option>
            @foreach ($vouchers as $voucher)
                <option value="{{ $voucher->id }}">{{ $voucher->off_percentage }}%</option>
            @endforeach
        </select>
        <button type="submit">Pay</button>
    </form>
</body>

</html>
