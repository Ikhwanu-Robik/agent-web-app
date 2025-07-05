<h1>Edit Bus Schedule</h1>

<ul>
    <li><a href="/master/vouchers">Master Vouchers</a></li>
    <li><a href="/master/bus">Master Bus</a></li>
    <li><a href="/master/bus/station">Master Bus Station</a></li>
    <li><a href="/master/bus/schedules">Master Bus Schedule</a></li>
</ul>

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="error" style="color:red">
            {{ $error }}
        </div>
    @endforeach
@endif

<form action="{{ '/master/bus/schedules/edit/' . $schedule->id }}" method="post">
    @csrf
    @method("PUT")
    <label for="bus">Bus Name</label>
    <select name="bus_id" id="bus">
        @foreach ($buses as $bus)
            @if ($bus->id == $schedule->bus->id)
                <option value="{{ $bus->id }}" selected>{{ $bus->name }}</option>
            @else
                <option value="{{ $bus->id }}">{{ $bus->name }}</option>
            @endif
        @endforeach
    </select>
    <br>

    <label for="origin_station">Origin Station</label>
    <select name="origin_station_id" id="origin_station">
        @foreach ($bus_stations as $station)
            @if ($station->id == $schedule->originStation->id)
                <option value="{{ $station->id }}" selected>{{ $station->name }}</option>
            @else
                <option value="{{ $station->id }}">{{ $station->name }}</option>
            @endif
        @endforeach
    </select>

    <label for="destination_station">Destination Station</label>
    <select name="destination_station_id" id="destination_station">
        @foreach ($bus_stations as $station)
            @if ($station->id == $schedule->destinationStation->id)
                <option value="{{ $station->id }}" selected>{{ $station->name }}</option>
            @else
                <option value="{{ $station->id }}">{{ $station->name }}</option>
            @endif
        @endforeach
    </select>
    <br>

    <label for="departure_date">Departure Date</label>
    <input type="date" name="departure_date" id="departure_date" value="{{ $schedule->departure_date }}">

    <label for="departure_time">Departure Time</label>
    <input type="time" name="departure_time" id="departure_time" value="{{ $schedule->departure_time }}">
    <br>

    <label for="seats">Avilable Seats</label>
    <input type="number" name="seats" id="seats" value="{{ $schedule->seats }}">
    <br>

    <label for="ticket_price">Ticket Price (Rp.)</label>
    <input type="number" name="ticket_price" id="ticket_price" value="{{ $schedule->ticket_price }}">

    <button type="submit">Save</button>
</form>
