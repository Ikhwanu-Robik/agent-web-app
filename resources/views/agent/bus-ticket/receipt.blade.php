<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bus Ticket</title>
    <link rel="stylesheet" href="{{ url('/assets/receipt.css') }}">
</head>

<body>
    <div id="container">
        <div id="receipt">
            <header>
                <h1 id="transaction-status">Transaction {{ $paymentMethod == 'cash' ? 'Successful' : 'Pending' }}</h1>
                <em id="timestamp">{{ $transaction->created_at }}</em> <br>
            </header>

            <section>
                <h2>Bus Tiket for {{ $transaction->busSchedule->bus->name }}</h2>

                <div>
                    <h4>From {{ $transaction->busSchedule->originStation->name }} To
                        {{ $transaction->busSchedule->destinationStation->name }}</h4>
                    <h4>Depart at
                        {{ $transaction->busSchedule->departure_date . ' ' . $transaction->busSchedule->departure_time }}
                    </h4>
                    <span>{{ $transaction->ticket_amount }}
                        Ticket{{ $transaction->ticket_amount > 1 ? 's' : '' }}</span> <br>
                    <h3>Rp.{{ $transaction->total }}</h3>
                    @if ($transaction->voucher)
                        <span>Voucher : {{ $transaction->voucher }}</span>
                    @endif
                </div>
                
                <h3 id="payment-method">Paid with {{ $paymentMethod }}</h3>
    
                @if ($paymentMethod == 'flip')
                    <h3>To pay with Flip, click <a href="{{ 'https://' . $flipResponse['link_url'] }}">this link</a></h3>
                @endif
            </section>

        </div>
    </div>

</body>

</html>
