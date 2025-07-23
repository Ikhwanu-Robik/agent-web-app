<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bus Ticket</title>
</head>

<body>
    <h1>Transaction Successful!</h1>

    <em>{{ $transaction->created_at }}</em> <br>
    <h2>Bus Tiket for {{ $transaction->busSchedule->bus->name }}</h2>

    <div>
        <h4>From {{ $transaction->busSchedule->originStation->name }} To
            {{ $transaction->busSchedule->destinationStation->name }}</h4>
        <h4>Depart at
            {{ $transaction->busSchedule->departure_date . ' ' . $transaction->busSchedule->departure_time }}</h4>
        <span>{{ $transaction->ticket_amount }} Ticket{{ $transaction->ticket_amount > 1 ? 's' : '' }}</span> <br>
        <h3>Rp.{{ $transaction->total }}</h3>
        <h3>Paid with {{ $payment_method }}</h3>
        @if ($transaction->voucher)
            <span>Voucher : {{ $transaction->voucher }}</span>
        @endif
    </div>
</body>

</html>
