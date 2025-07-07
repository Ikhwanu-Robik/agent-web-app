<h1>Admin BPJS</h1>

@include("components.master.header")

<a href="/master/bpjs/prices/create">
    <button>Create</button>
</a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Class</th>
        <th>Price</th>
        <th>Date Created</th>
        <th>Date Updated</th>
        <th>Actions</th>
    </tr>
    @foreach ($bpjs_prices as $bpjs)
        <tr>
            <td>{{ $bpjs->id }}</td>
            <td>{{ $bpjs->class }}</td>
            <td>Rp.{{ number_format($bpjs->price, 0, ".") }}</td>
            <td>{{ $bpjs->created_at }}</td>
            <td>{{ $bpjs->updated_at }}</td>
            <td><a href="{{ '/master/bpjs/prices/edit/' . $bpjs->id }}"><button>Update</button></a><a
                    href="{{ '/master/bpjs/prices/delete/' . $bpjs->id }}"><button>Delete</button></a></td>
        </tr>
    @endforeach
</table>
