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
        <h1>Beli Tiket Bus</h1>

        @if ($errors->any())
            <div class="error" style="color:red">
                @foreach ($errors->all() as $error)
                    <div>
                        {{ $error }}
                    </div>
                @endforeach
            </div>
        @endif

        <form action="/bus/schedules" method="post">
            @csrf

            <label for="origin">Dari</label>
            <select name="origin" id="origin">
                @foreach ($busStations as $station)
                    <option value="{{ $station->id }}"
                        {{ session('_old_input') && session('_old_input')['origin'] == $station->id ? 'selected' : '' }}>
                        {{ $station->name }}</option>
                @endforeach
            </select>
            <label for="destination">Tujuan</label>
            <select name="destination" id="destination">
                @foreach ($busStations as $station)
                    <option value="{{ $station->id }}"
                        {{ session('_old_input') && session('_old_input')['destination'] == $station->id ? 'selected' : '' }}>
                        {{ $station->name }}</option>
                @endforeach
            </select>
            <label for="ticket-amount">Jumlah Tiket</label>
            <input type="number" name="ticket_amount" id="ticket-amount" min="1"
                value="{{ old('ticket_amount') ? old('ticket_amount') : 1 }}">

            <button type="submit">Cari</button>
        </form>

        @php
            $counter = 0;

            if (session('matching_schedules')) {
                foreach (session('matching_schedules') as $schedule) {
                    $counter++;
                }
            }
        @endphp

        @if ($counter == 0 && session('redirect_status'))
            <h2>Tidak ada jadwal yang sesuai</h2>
        @elseif ($counter != 0)
            <h2>Jadwal Sesuai</h2>
            <ul>
                @foreach (session('matching_schedules') as $schedule)
                    <li>
                        <section id="matching_schedules">
                            <h3>{{ $schedule->bus->name }}</h3>
                            <span>dari</span> <b>{{ $schedule->originStation->name }}</b> <span>ke</span>
                            <b>{{ $schedule->destinationStation->name }}</b> <br>
                            <span>berangkat</span> <b>{{ $schedule->departure_date }}</b>
                            <b>{{ $schedule->departure_time }}</b>
                            <br>
                            <span>kursi tersedia</span> <b>{{ $schedule->seats }}</b> <br>
                            <b>Rp. {{ $schedule->ticket_price }} / tiket</b>
                            <form action="/bus/ticket" method="post" style="display:inline">
                                @csrf
                                <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                                <input type="hidden" name="ticket_amount"
                                    value="{{ session('_old_input')['ticket_amount'] }}" />
                                <button type="submit">Beli {{ session('_old_input')['ticket_amount'] }} tiket</button>
                            </form>
                        </section>
                    </li>
                @endforeach
            </ul>
        @endif

    </main>
</body>

</html>
