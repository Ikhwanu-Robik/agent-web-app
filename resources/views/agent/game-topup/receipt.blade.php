<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Game Top Up</title>
    <link rel="stylesheet" href="{{ url('/assets/receipt.css') }}">
</head>

<body>
    <div id="container">
        <div id="receipt">
            <header>
                <h1 id="transaction-status">Transaction {{ $transaction->method == 'cash' ? 'Successful' : 'Pending' }}
                </h1>
                <em id="timestamp">{{ $transaction->created_at }}</em> <br>
            </header>

            <section>
                <div>
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
                        @if ($transaction->voucher)
                            <tr>
                                <td>Voucher</td>
                                <td>:</td>
                                <td>{{ $transaction->voucher }}</td>
                            </tr>
                        @endif
                    </table>
                </div>

                <h3 id="payment-method">Paid with {{ $transaction->method }}</h3>

                @if ($transaction->method == 'flip')
                    <h3>To pay with Flip, click <a href="{{ 'https://' . $flipResponse['link_url'] }}">this link</a>
                    </h3>
                @endif
            </section>

        </div>
    </div>

</body>

</html>