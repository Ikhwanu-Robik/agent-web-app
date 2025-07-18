<h1>Add New Game Package</h1>

@include('components.master.header')

@foreach ($errors->all() as $error)
    {{ $error }} <br />
@endforeach

<form action="/master/games/packages/create" method="post">
    @csrf
    <label for="game">game</label>
    <select name="game_id" id="game">
        @foreach ($games as $game)
            <option value="{{ $game->id }}">{{ $game->name }}</option>
        @endforeach
    </select>
    <label for="title">title</label>
    <input type="text" name="title" id="title"> <br>
    <label for="items">items amount</label>
    <input type="number" name="items_count" id="items"> <br>
    <label for="price">price</label>
    <input type="number" name="price" id="price">

    <button type="submit">Add</button>
</form>
