<h1>Are You Sure To Delete <em>'{{ $schedule->bus->name . "-" . $schedule->originStation->name . "-" . $schedule->destinationStation->name}}'</em> ?</h1>

<ul>
    <li><a href="/master/vouchers">Master Vouchers</a></li>
    <li><a href="/master/bus">Master Bus</a></li>
    <li><a href="/master/bus/station">Master Bus Station</a></li>
    <li><a href="/master/bus/schedules">Master Bus Schedule</a></li>
</ul>

<form action="{{ "/master/bus/schedules/delete/" . $schedule->id }}" method="post" style="display:inline">
    @csrf
    @method("DELETE")
    <input type="hidden" name="schedule" value="{{ $schedule->id }}">
    <button type="submit">Yes</button>
</form>
<a href="/master/bus/schedules"><button>No</button></a>