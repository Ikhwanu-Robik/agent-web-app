<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BPJS Extension</title>
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
                <h2>Extend BPJS for {{ $transaction->month_bought }} months</h2>

                <div>
                    <h3>Your BPJS Status</h3>
                    <table border="1">
                        <tr>
                            <th>NIK</th>
                            <th>Active until</th>
                        </tr>
                        <tr>
                            <td>{{ $bpjs->civilInformation->NIK }}</td>
                            <td>{{ $bpjs->dueDate() }}</td>
                        </tr>
                    </table>
                    <span>Total <b>Rp.{{ number_format($transaction->total, 0, '.') }}</b></span> <br>
                    <span>Payment method <b>{{ $transaction->method }}</b></span>
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