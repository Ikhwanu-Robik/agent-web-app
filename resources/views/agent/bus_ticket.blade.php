<h1>Beli Tiket Bus</h1>

<form action="/bus-ticket" method="post">
    @csrf

    <label for="departure-date">Tanggal Berangkat</label>
    <input type="date" name="departure-date" id="departure-date">
    <br>

    <label for="origin">Dari</label>
    <select name="origin" id="origin">
        @foreach ($bus_stations as $station)
            <option value="{{ $station->id }}">{{ $station->name }}</option>
        @endforeach
    </select>
    <label for="destination">Tujuan</label>
    <select name="destination" id="destination">
        @foreach ($bus_stations as $station)
            <option value="{{ $station->id }}">{{ $station->name }}</option>
        @endforeach
    </select>
    <label for="ticket-amount">Jumlah Tiket</label>
    <input type="number" name="ticket_amount" id="ticket-amount" min="1" value="1">

    <button type="submit">Cari</button>
</form>

@if ($matching_schedules)
    <h2>Jadwal Sesuai</h2>
    @foreach ($matching_schedules as $schedule)
        <section id="matching_schedules">
            <form action="" method="post">
                <h3>{{ $schedule->bus->name }}</h3>
                <span>dari</span> <b>{{ $schedule->origin->name }}</b> <span>ke</span> <b>{{ $schedule->destination->name }}</b> <br>
                <span>berangkat</span> <b>{{ $schedule->date }}</b> <b>{{ $schedule->time }}</b> <br>
                <span>kursi tersedia</span> <b>{{ $schedule->seat }}</b> <br>
                <b>Rp. {{ $schedule->ticket_price }} / tiket</b>
                <form action="" method="post" style="display:inline">@csrf<button type="submit">Beli</button>
                </form>
            </form>
        </section>
    @endforeach
@endif
