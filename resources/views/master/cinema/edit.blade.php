<h1>Edit Cinema</h1>

@include('components.master.header')

@foreach ($errors->all() as $error)
    {{ $error }} <br />
@endforeach

<form action="{{ '/master/cinemas/edit/' . $cinema->id }}" method="post">
    @csrf
    @method('PUT')
    <label for="name">Name</label>
    <input type="text" name="name" id="name" value="{{ $cinema->name }}">
    @php
        $seatsStructure = json_decode($cinema->seats_structure);
        $row = count($seatsStructure);
        $col = count($seatsStructure[0]);
    @endphp
    <h3>Change seat size</h3>
    <label for="seats_structure_col">Seats columns</label>
    <input type="number" name="seats_structure_width" id="seats_structure_col" value="{{ $col }}">
    <br>
    <label for="seats_structure_rows">Seats rows</label>
    <input type="number" name="seats_structure_height" id="seats_structure_row" value="{{ $row }}">

    <button type="submit">Save</button>
</form>
