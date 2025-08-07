<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vouchers</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: sans-serif;
        }

        header {
            width: 100vw;
            height: 10vh;
            background-color: rgb(37, 104, 175);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2em;
        }

        header>div {
            height: 100%;
            display: flex;
            align-items: center;
            gap: 1em;
        }

        header>div>#profile_photo:hover+#username {
            display: block;
        }

        header>div>#username {
            position: absolute;
            top: 4em;
            left: 1em;
            background-color: white;
            padding: 0.1em;
            border: 1px solid black;
            border-radius: 5%;
            display: none;
        }

        header>div>#profile_photo {
            height: 80%;
            border-radius: 50%
        }

        header>div>.nav-button {
            text-decoration: none;
            padding: 1em;
            color: white;
            font-weight: bold;
        }

        header>div>.nav-button:hover {
            background-color: rgb(15, 80, 151);
        }

        header>form>#logout-button {
            padding: 0.5em 1em;
            font-weight: bold;
            color: white;
            background-color: rgb(10, 60, 114);
            border: none;
        }

        #voucher-container {
            display: flex;
            gap: 1em;
            margin: 0.5em;
        }

        .voucher {
            background-color: rgb(255, 255, 98);
            padding: 1em;
        }
    </style>
</head>

<body>
    @include('components.header')

    <main>
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

        <form action="{{ '/game/topup/package/' . $package->id . '/pay' }}" method="post">
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
    </main>
</body>

</html>
