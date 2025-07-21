<h1>Are You Sure To Delete This Power Voltage?</h1>

@include('components.master.header')

<table border="1">
    <tr>
        <th>ID</th>
        <th>volts</th>
        <th>monthly_price</th>
        <th>Date Created</th>
        <th>Date Updated</th>
    </tr>
    <tr>
        <td>{{ $power_voltage->id }}</td>
        <td>{{ $power_voltage->volts }}</td>
        <td>{{ $power_voltage->monthly_price }}</td>
        <td>{{ $power_voltage->created_at }}</td>
        <td>{{ $power_voltage->updated_at }}</td>
    </tr>
</table>

<form action="{{ '/master/power/voltages/delete/' . $power_voltage->id }}" method="post" style="display:inline">
    @csrf
    @method('DELETE')
    <input type="hidden" name="power_voltage" value="{{ $power_voltage->id }}">
    <button type="submit">Yes</button>
</form>
<a href="/master/power/voltages"><button>No</button></a>
