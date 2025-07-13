<h1>Master Cinema</h1>

@include('components.master.header')

<a href="/master/cinemas/create">
    <button>Create</button>
</a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Seats structure</th>
        <th>Created at</th>
        <th>Updated at</th>
        <th>Actions</th>
    </tr>
    @foreach ($cinemas as $cinema)
        <tr>
            <td>{{ $cinema->id }}</td>
            <td>{{ $cinema->name }}</td>
            <td>
                <table>
                    @foreach (json_decode($cinema->seats_structure) as $row)
                        <tr>
                            @foreach ($row as $col)
                                <td>
                                    <input type="checkbox" name="" id="" {{ $col == 1 ? 'checked' : '' }}
                                        disabled>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </table>
            </td>
            <td>{{ $cinema->created_at }}</td>
            <td>{{ $cinema->updated_at }}</td>
            <td>
                <a href="{{ '/master/cinemas/' . $cinema->id . '/films' }}"><button>Manage film</button></a>
                <a href="{{ '/master/cinemas/edit/' . $cinema->id }}"><button>Update</button></a>
                <a
                    href="{{ '/master/cinemas/delete/' . $cinema->id }}"><button>Delete</button></a>
                </td>
        </tr>
    @endforeach
</table>
