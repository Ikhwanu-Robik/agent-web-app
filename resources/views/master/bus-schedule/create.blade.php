<h1>Add New Bus Schedule</h1>

@include("components.master.header")

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="error" style="color:red">
            {{ $error }}
        </div>
    @endforeach
@endif

<form action="/master/bus/schedules/create" method="post">
    @csrf
    <label for="bus">Bus Name</label>
    <select name="bus_id" id="bus">
        @foreach ($buses as $bus)
            <option value="{{ $bus->id }}">{{ $bus->name }}</option>
        @endforeach
    </select>
    <br>

    <label for="origin_station">Origin Station</label>
    <select name="origin_station_id" id="origin_station">
        @foreach ($busStations as $station)
            <option value="{{ $station->id }}">{{ $station->name }}</option>
        @endforeach
    </select>

    <label for="destination_station">Destination Station</label>
    <select name="destination_station_id" id="destination_station">
        @foreach ($busStations as $station)
            <option value="{{ $station->id }}">{{ $station->name }}</option>
        @endforeach
    </select>
    <br>

    <label for="departure_date">Departure Date</label>
    <input type="date" name="departure_date" id="departure_date">

    <label for="departure_time">Departure Time</label>
    <input type="time" name="departure_time" id="departure_time">
    <br>

    <label for="seats">Avilable Seats</label>
    <input type="number" name="seats" id="seats">
    <br>

    <label for="ticket_price">Ticket Price (Rp.)</label>
    <input type="number" name="ticket_price" id="ticket_price">

    <button type="submit">Add</button>
</form>
