<h1>Admin Vouchers</h1>

<a href="/master/vouchers/create">
    <button>Create</button>
</a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Off Percentage</th>
        <th>Valid Service</th>
        <th>User</th>
        <th>Date Created</th>
        <th>Date Updated</th>
        <th>Actions</th>
    </tr>
    @foreach ($vouchers as $voucher)
        <tr>
            <td>{{ $voucher->id }}</td>
            <td>{{ $voucher->off_percentage }}</td>
            <td>{{ $voucher->valid_for }}</td>
            <td>{{ $voucher->user->name }}</td>
            <td>{{ $voucher->created_at }}</td>
            <td>{{ $voucher->updated_at }}</td>
            <td><a href="{{ '/master/vouchers/edit/' . $voucher->id }}"><button>Update</button></a><a
                    href="{{ '/master/vouchers/delete/' . $voucher->id }}"><button>Delete</button></a></td>
        </tr>
    @endforeach
</table>
