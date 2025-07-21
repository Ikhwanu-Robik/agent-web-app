<h1>Edit Game</h1>

@include('components.master.header')

@foreach ($errors->all() as $error)
    {{ $error }} <br />
@endforeach

<form action="{{ '/master/games/edit/' . $game->id }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <label for="name">name</label>
    <input type="text" name="name" id="name" value="{{ $game->name }}"> <br>
    <label for="icon">icon</label>
    <input type="file" name="icon" id="icon"> <br>
    <label for="currency">currency</label>
    <input type="text" name="currency" id="currency" value="{{ $game->currency }}">

    <button type="submit">Save</button>
</form>
