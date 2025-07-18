<h1>Top Up Game</h1>
<h2>Pilih Game</h2>

<form action="/game/packages" method="post">
    @csrf
    <select name="game_id" id="">
        @foreach ($games as $game)
            <option value="{{ $game->id }}">{{ $game->name }}</option>
        @endforeach
    </select>
    <button type="submit">Pilih</button>
</form>

@if ($packages)
    <div>
        <ul>
            @foreach ($packages as $package)
                <li>
                    <div>
                        <h3>{{ $package->title }}</h3>
                        <span>{{ $package->game->name }}</span> <br>
                        <em>{{ $package->items_count }} {{ $package->game->currency }} - {{ $package->price }}</em>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endif
