<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bus Ticket</title>
</head>

<body>
    <h2>
        You're About to Buy Bus Tiket for {{ $transaction->busSchedule->bus->name }}</h2>

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
            <input type="hidden" name="bus_schedule_id" value="{{ $transaction->bus_schedule_id }}" />
            <input type="hidden" name="ticket_amount" value="{{ $transaction->ticket_amount }}" />
            <label for="payment_method">Payment Method</label>
            <select name="payment_method" id="payment_method">
                <option value="cash">Cash</option>
                <option value="flip">Flip</option>
            </select>
            <label for="voucher">Voucher</label>
            <select name="voucher" id="voucher">
                <option value="-1">No Voucher</option>
                @foreach ($vouchers as $voucher)
                    <option value="{{ $voucher->id }}">{{ $voucher->off_percentage }}% - @foreach (json_decode($voucher->valid_for) as $valid_service)
                            {{ $valid_service }},
                        @endforeach
                    </option>
                @endforeach
            </select>
            <input type="hidden" name="bus_ticket_transaction_id" value="{{ $transaction->id }}">
            <button type="submit">PAY</button>
        </form>
    </div>

</body>

</html>
