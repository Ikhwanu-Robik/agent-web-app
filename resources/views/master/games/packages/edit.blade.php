<h1>Edit Game Package</h1>

@include('components.master.header')

@foreach ($errors->all() as $error)
    {{ $error }} <br />
@endforeach

<form action="{{ '/master/games/packages/edit/' . $package->id }}" method="post">
    @csrf
    @method('PUT')
    <label for="game">game</label>
    <select name="game_id" id="game">
        @foreach ($games as $game)
            <option value="{{ $game->id }}" {{ $game->id == $package->game_id ? "selected" : "" }}>{{ $game->name }}</option>
        @endforeach
    </select>
    <label for="title">title</label>
    <input type="text" name="title" id="title" value="{{ $package->title }}"> <br>
    <label for="items">items amount</label>
    <input type="number" name="items_count" id="items" value="{{ $package->items_count }}"> <br>
    <label for="price">price</label>
    <input type="number" name="price" id="price" value="{{ $package->price }}">

    <button type="submit">Save</button>
</form>
