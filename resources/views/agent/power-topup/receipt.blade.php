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
                    <table border="1">
                        <tr>
                            <th>Subsciber Number</th>
                            <th>Nominal Power</th>
                            @if ($transaction->voucher)
                                <th>Voucher</th>
                            @endif
                        </tr>
                        <tr>
                            <td>{{ $transaction->subscriber_number }}</td>
                            <td>{{ $transaction->total }}</td>
                            @if ($transaction->voucher)
                                <td>{{ $transaction->voucher }}</td>
                            @endif
                        </tr>
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