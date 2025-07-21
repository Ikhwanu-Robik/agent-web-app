<h1>Add New Game</h1>

@include('components.master.header')

@foreach ($errors->all() as $error)
    {{ $error }} <br />
@endforeach

<form action="/master/games/create" method="post" enctype="multipart/form-data">
    @csrf
    <label for="name">name</label>
    <input type="text" name="name" id="name"> <br>
    <label for="icon">icon</label>
    <input type="file" name="icon" id="icon"> <br>
    <label for="currency">currency</label>
    <input type="text" name="currency" id="currency">

    <button type="submit">Add</button>
</form>
