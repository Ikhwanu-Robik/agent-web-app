<h1>Add New Cinema</h1>

@include('components.master.header')

@foreach ($errors->all() as $error)
    {{ $error }} <br />
@endforeach

<form action="/master/cinemas/create" method="post">
    @csrf
    <label for="name">Name</label>
    <input type="text" name="name" id="name">
    <br>
    <label for="seats_structure_col">Seats columns</label>
    <input type="number" name="seats_structure_width" id="seats_structure_col">
    <label for="seats_structure_rows">Seats rows</label>
    <input type="number" name="seats_structure_height" id="seats_structure_row">

    <button type="submit">Add</button>
</form>
