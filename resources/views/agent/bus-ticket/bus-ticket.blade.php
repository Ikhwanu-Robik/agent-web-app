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
