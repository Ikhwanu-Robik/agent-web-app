<h1>Admin Bus</h1>

@include("components.master.header")

<a href="/master/bus/create">
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
    @foreach ($buses as $bus)
        <tr>
            <td>{{ $bus->id }}</td>
            <td>{{ $bus->name }}</td>
            <td>{{ $bus->created_at }}</td>
            <td>{{ $bus->updated_at }}</td>
            <td><a href="{{ '/master/bus/edit/' . $bus->id }}"><button>Update</button></a><a
                    href="{{ '/master/bus/delete/' . $bus->id }}"><button>Delete</button></a></td>
        </tr>
    @endforeach
</table>
