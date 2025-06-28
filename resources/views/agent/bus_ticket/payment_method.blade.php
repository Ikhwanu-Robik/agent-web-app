@php
    $transaction = session('transaction_data');
@endphp

@if (session('transaction_data'))
    <h2>You're About to Buy Bus Tiket for {{ $transaction->busSchedule->bus->name }}</h2>

    <div>
        <h4>From {{ $transaction->busSchedule->originStation->name }} To
            {{ $transaction->busSchedule->destinationStation->name }}</h4>
        <h4>Depart at {{ $transaction->busSchedule->departure_date . ' ' . $transaction->busSchedule->departure_time }}
        </h4>
        <span>{{ $transaction->ticket_amount }} Ticket{{ $transaction->ticket_amount > 1 ? 's' : '' }}</span> <br>
        <h3>Rp.{{ $transaction->total }}</h3>
        <h3>Choose your payment method</h3>
        <form action="/bus/ticket/pay" method="post" style="display:inline">
            @csrf
            <input type="hidden" name="payment_method" value="cash">
            <button type="submit">CASH</button>
        </form>
        <form action="/bus/ticket/pay" method="post" style="display:inline">
            @csrf
            <input type="hidden" name="payment_method" value="flip">
            <button type="submit">FLIP</button>
        </form>
    </div>
@else
    Oops, it seems there is no transaction data here!
@endif
