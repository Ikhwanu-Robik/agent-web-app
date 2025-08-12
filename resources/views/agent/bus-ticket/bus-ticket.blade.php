<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bus Ticket</title>
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

        main {
            padding: 3em;
            display: flex;
            flex-direction: column;
            gap: 1em;
        }

        main input, main button, main select {
            padding: 0.2em;
        }

        main button {
            background-color: rgb(0, 128, 255);
            color: white;
            border: none;
            padding: 0.5em;
        }

        main button:hover {
            background-color: rgb(0, 200, 255);
        }
    </style>
</head>

<body>
    @include('components.header')

    <main>
        <h1>Buy Bus Ticket</h1>

        @if ($errors->any())
            <div class="error" style="color:red">
                @foreach ($errors->all() as $error)
                    <div>
                        {{ $error }}
                    </div>
                @endforeach
            </div>
        @endif

        <form action="{{ route("bus_ticket_transaction.find_package") }}" method="post">
            @csrf

            <label for="origin">From</label>
            <select name="origin" id="origin">
                @foreach ($busStations as $station)
                    <option value="{{ $station->id }}"
                        {{ session('_old_input') && session('_old_input')['origin'] == $station->id ? 'selected' : '' }}>
                        {{ $station->name }}</option>
                @endforeach
            </select>
            <label for="destination">To</label>
            <select name="destination" id="destination">
                @foreach ($busStations as $station)
                    <option value="{{ $station->id }}"
                        {{ session('_old_input') && session('_old_input')['destination'] == $station->id ? 'selected' : '' }}>
                        {{ $station->name }}</option>
                @endforeach
            </select>
            <label for="ticket-amount">Quantity</label>
            <input type="number" name="ticket_amount" id="ticket-amount" min="1"
                value="{{ old('ticket_amount') ? old('ticket_amount') : 1 }}">

            <button type="submit">Search Ticket</button>
        </form>

        @php
            $counter = 0;

            if (session('matching_schedules')) {
                foreach (session('matching_schedules') as $schedule) {
                    $counter++;
                }
            }
        @endphp

        <div>
            @if ($counter == 0 && session('redirect_status'))
                <h2>No matching schedule</h2>
            @elseif ($counter != 0)
                <ul>
                    @foreach (session('matching_schedules') as $schedule)
                        <li>
                            <section id="matching_schedules">
                                <h3>{{ $schedule->bus->name }}</h3>
                                <span>From</span> <b>{{ $schedule->originStation->name }}</b>
                                <span>To</span> <b>{{ $schedule->destinationStation->name }}</b> <br>
                                <span>Depart at </span> <b>{{ $schedule->departure_date }}</b>
                                <b>{{ $schedule->departure_time }}</b>
                                <br>
                                <span>Seats remaining</span> <b>{{ $schedule->seats }}</b> <br>
                                <b>Rp. {{ $schedule->ticket_price }} / ticket</b>
                                <form action="{{ route("bus_ticket_transaction.order") }}" method="post" style="display:inline">
                                    @csrf
                                    <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                                    <input type="hidden" name="ticket_amount"
                                        value="{{ session('_old_input')['ticket_amount'] }}" />
                                    <button type="submit">Buy {{ session('_old_input')['ticket_amount'] }} ticket</button>
                                </form>
                            </section>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

    </main>
</body>

</html>
