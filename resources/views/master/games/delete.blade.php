<h1>Are You Sure To Delete {{ $game->name }}?</h1>
<img src="{{ asset($game->icon) }}" alt="" width="150em">

@include('components.master.header')

<form action="{{ "/master/games/delete/" . $game->id }}" method="post" style="display:inline">
    @csrf
    @method("DELETE")
    <input type="hidden" name="game" value="{{ $game->id }}">
    <button type="submit">Yes</button>
</form>
<a href="/master/games"><button>No</button></a>
