<h1>Are You Sure To Delete {{ $bus->name }} ?</h1>

<ul>
    <li><a href="/master/vouchers">Master Vouchers</a></li>
    <li><a href="/master/bus">Master Bus</a></li>
    <li><a href="/master/bus/station">Master Bus Station</a></li>
    <li><a href="/master/bus/schedules">Master Bus Schedule</a></li>
</ul>

<form action="{{ "/master/bus/delete/" . $bus->id }}" method="post" style="display:inline">
    @csrf
    @method("DELETE")
    <input type="hidden" name="bus" value="{{ $bus->id }}">
    <button type="submit">Yes</button>
</form>
<a href="/master/bus"><button>No</button></a>