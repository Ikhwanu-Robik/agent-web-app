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
        <h2>
            You're About to Buy Bus Tiket for {{ $transaction->busSchedule->bus->name }}</h2>

        <div>
            <h4>From {{ $transaction->busSchedule->originStation->name }} To
                {{ $transaction->busSchedule->destinationStation->name }}</h4>
            <h4>Depart at
                {{ $transaction->busSchedule->departure_date . ' ' . $transaction->busSchedule->departure_time }}
            </h4>
            <span>{{ $transaction->ticket_amount }} Ticket{{ $transaction->ticket_amount > 1 ? 's' : '' }}</span> <br>
            <h3>Rp.{{ $transaction->total }}</h3>
            <h3>Choose your payment method</h3>
            <form action="{{ route("bus_ticket_transaction.pay") }}" method="post" style="display:inline">
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
                        <option value="{{ $voucher->id }}">{{ $voucher->off_percentage }}% - @foreach (json_decode($voucher->valid_for) as $validService)
                                {{ $validService }},
                            @endforeach
                        </option>
                    @endforeach
                </select>
                <input type="hidden" name="bus_ticket_transaction_id" value="{{ $transaction->id }}">
                <button type="submit">PAY</button>
            </form>
        </div>
    </main>
</body>

</html>
