<h1>Are You Sure To Delete {{ $film->title }}?</h1>
<img src="{{ asset($film->poster_image_url) }}" alt="" width="150em">

@include('components.master.header')

<form action="{{ "/master/films/delete/" . $film->id }}" method="post" style="display:inline">
    @csrf
    @method("DELETE")
    <input type="hidden" name="film" value="{{ $film->id }}">
    <button type="submit">Yes</button>
</form>
<a href="/master/films"><button>No</button></a>
