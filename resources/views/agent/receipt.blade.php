<html>

<body>
    @if (session('transaction_type'))
        <h1>Transaction Successful!</h1>
        @php
            $transaction = session("transaction_data");   
        @endphp
    @endif

    @switch(session("transaction_type"))
        @case('bus_ticket')
            <em>{{ $transaction->created_at }}</em> <br>
            <h2>Bus Tiket for {{ $transaction->busSchedule->bus->name }}</h2>

            <div>
                <h4>From {{ $transaction->busSchedule->originStation->name }} To {{ $transaction->busSchedule->destinationStation->name }}</h4>
                <h4>Depart at {{ $transaction->busSchedule->departure_date . " " . $transaction->busSchedule->departure_time }}</h4>
                <span>{{ $transaction->ticket_amount }} Ticket{{ $transaction->ticket_amount > 1 ? "s" : "" }}</span> <br>
                <h3>Rp.{{ $transaction->total }}</h3>
                <h3>Paid with Flip/Cash</h3>
            </div>
        @break

        @default
            Oops, it seems there is no transaction data here!
    @endswitch
</body>

</html>
