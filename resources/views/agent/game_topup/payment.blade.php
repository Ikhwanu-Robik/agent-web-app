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
        <select name="payment_method" id="">
            <option value="cash">cash</option>
            <option value="flip">flip</option>
        </select>
        <button type="submit">Pay</button>
    </form>
</body>

</html>
