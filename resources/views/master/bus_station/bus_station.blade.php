<h1>Admin Stasiun Bus</h1>

<a href="/master/bus/station/create">
    <button>Create</button>
</a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Date Created</th>
        <th>Date Updated</th>
        <th>Actions</th>
    </tr>
    @foreach ($bus_stations as $station)
        <tr>
            <td>{{ $station->id }}</td>
            <td>{{ $station->name }}</td>
            <td>{{ $station->created_at }}</td>
            <td>{{ $station->updated_at }}</td>
            <td><a href="{{ "/master/bus/station/edit/" . $station->id }}"><button>Update</button></a><a href="{{ "/master/bus/station/delete/" . $station->id }}"><button>Delete</button></a></td>
        </tr>
    @endforeach
</table>
