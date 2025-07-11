<h1>Are You Sure To Delete This Voucher?</h1>

<ul>
    <li><a href="/master/vouchers">Master Vouchers</a></li>
    <li><a href="/master/bus">Master Bus</a></li>
    <li><a href="/master/bus/station">Master Bus Station</a></li>
    <li><a href="/master/bus/schedules">Master Bus Schedule</a></li>
</ul>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Off Percentage</th>
        <th>Valid Service</th>
        <th>User</th>
        <th>Date Created</th>
        <th>Date Updated</th>
    </tr>
        <tr>
            <td>{{ $voucher->id }}</td>
            <td>{{ $voucher->off_percentage }}</td>
            <td>{{ $voucher->valid_for }}</td>
            <td>{{ $voucher->user->name }}</td>
            <td>{{ $voucher->created_at }}</td>
            <td>{{ $voucher->updated_at }}</td>
        </tr>
</table>

<form action="{{ "/master/vouchers/delete/" . $voucher->id }}" method="post" style="display:inline">
    @csrf
    @method("DELETE")
    <input type="hidden" name="voucher" value="{{ $voucher->id }}">
    <button type="submit">Yes</button>
</form>
<a href="/master/vouchers"><button>No</button></a>
