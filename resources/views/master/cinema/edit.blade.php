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
    <table>
        <tr>
            <td>
                <h3>
                    <label for="fill_seats">Change seat fillings</label>
                </h3>
                <table>
                    @php
                    $seats_structure = json_decode($cinema->seats_structure);
                    $row = 0;
                    $col = 0;
                    @endphp
                    @for ($row = 0; $row < count($seats_structure); $row++)
                        <tr>
                            @for ($col = 0; $col < count($seats_structure[$row]); $col++)
                                <td>
                                    <input type="checkbox" name="seats_structure[]" value="{{ $row . "," . $col }}" {{ $seats_structure[$row][$col] == 1 ? 'checked' : '' }}>
                                </td>
                            @endfor
                        </tr>
                    @endfor
                </table>
            </td>
            <td>OR</td>
            <td>
                <h3>Change seat size</h3>
                <label for="seats_structure_col">Seats columns</label>
                <input type="number" name="seats_structure_width" id="seats_structure_col" value="{{ $col }}">
                <br>
                <label for="seats_structure_rows">Seats rows</label>
                <input type="number" name="seats_structure_height" id="seats_structure_row" value="{{ $row }}">
            </td>
        </tr>
    </table>

    <button type="submit">Save</button>
</form>
