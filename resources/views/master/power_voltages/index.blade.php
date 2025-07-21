<h1>Admin Power Voltages</h1>

@include('components.master.header')

<a href="/master/power/voltages/create">
    <button>Create</button>
</a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>volts</th>
        <th>monthly_price</th>
        <th>Date Created</th>
        <th>Date Updated</th>
        <th>Actions</th>
    </tr>
    @foreach ($power_voltages as $power_voltage)
        <tr>
            <td>{{ $power_voltage->id }}</td>
            <td>{{ $power_voltage->volts }}</td>
            <td>{{ $power_voltage->monthly_price }}</td>
            <td>{{ $power_voltage->created_at }}</td>
            <td>{{ $power_voltage->updated_at }}</td>
            <td><a href="{{ '/master/power/voltages/edit/' . $power_voltage->id }}"><button>Update</button></a><a
                    href="{{ '/master/power/voltages/delete/' . $power_voltage->id }}"><button>Delete</button></a></td>
        </tr>
    @endforeach
</table>
