<h1>Air a Film at {{ $cinema->name }}</h1>

<form action="{{ "/master/cinemas/" . $cinema->id . "/films/schedule" }}" method="post">
    @csrf
    <label for="film">Choose film</label>
    <select name="film" id="film">
        @foreach ($films as $film)
            <option value="{{ $film->id }}">
                <img src="{{ asset($film->poster_image_url) }}" alt="">
                <span>{{ $film->title }}</span>
            </option>
        @endforeach
    </select>
    <label for="ticket_price">Ticket price</label>
    <input type="number" name="ticket_price" id="ticket_price">
    <label for="date">Datetime of Airing</label>
    <input type="datetime-local" name="datetime_airing" id="datetime">

    <button type="submit">Schedule</button>
</form>