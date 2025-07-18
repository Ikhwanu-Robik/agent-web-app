<h1>Master Game Package</h1>

@include('components.master.header')

<a href="/master/games/packages/create">
    <button>Create</button>
</a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Game</th>
        <th>Title</th>
        <th>Items</th>
        <th>Price</th>
        <th>Created at</th>
        <th>Updated at</th>
        <th>Actions</th>
    </tr>
    @foreach ($packages as $package)
        <tr>
            <td>{{ $package->id }}</td>
            <td>{{ $package->title }}</td>
            <td>{{ $package->game->name }}</td>
            <td>{{ $package->items_count }}</td>
            <td>{{ $package->price }}</td>
            <td>{{ $package->created_at }}</td>
            <td>{{ $package->updated_at }}</td>
            <td><a href="{{ '/master/games/packages/edit/' . $package->id }}"><button>Update</button></a><a
                    href="{{ '/master/games/packages/delete/' . $package->id }}"><button>Delete</button></a></td>
        </tr>
    @endforeach
</table>
