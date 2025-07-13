<h1>Add New Film</h1>

@include('components.master.header')

@foreach ($errors->all() as $error)
    {{ $error }} <br />
@endforeach

<form action="/master/films/create" method="post" enctype="multipart/form-data">
    @csrf
    <label for="title">Title</label>
    <input type="text" name="title" id="title"> <br>
    <label for="poster">Poster</label>
    <input type="file" name="poster" id="poster"> <br>
    <label for="release_date">Release date</label>
    <input type="date" name="release_date" id="release_date"> <br>
    <label for="duration">Duration (minutes)</label>
    <input type="number" name="duration" id="duration">

    <button type="submit">Add</button>
</form>
