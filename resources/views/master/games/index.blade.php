<h1>Master Game</h1>

@include('components.master.header')

<a href="/master/games/create">
    <button>Create</button>
</a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>name</th>
        <th>icon</th>
        <th>currency</th>
        <th>Created at</th>
        <th>Updated at</th>
        <th>Actions</th>
    </tr>
    @foreach ($games as $game)
        <tr>
            <td>{{ $game->id }}</td>
            <td>{{ $game->name }}</td>
            <td><img src="{{ asset($game->icon) }}" width="150em"></td>
            <td>{{ $game->currency }}</td>
            <td>{{ $game->created_at }}</td>
            <td>{{ $game->updated_at }}</td>
            <td><a href="{{ '/master/games/edit/' . $game->id }}"><button>Update</button></a><a
                    href="{{ '/master/games/delete/' . $game->id }}"><button>Delete</button></a></td>
        </tr>
    @endforeach
</table>
