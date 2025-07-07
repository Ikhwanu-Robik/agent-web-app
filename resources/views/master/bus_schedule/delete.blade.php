<h1>Are You Sure To Delete <em>'{{ $schedule->bus->name . "-" . $schedule->originStation->name . "-" . $schedule->destinationStation->name}}'</em> ?</h1>

@include("components.master.header")

<form action="{{ "/master/bus/schedules/delete/" . $schedule->id }}" method="post" style="display:inline">
    @csrf
    @method("DELETE")
    <input type="hidden" name="schedule" value="{{ $schedule->id }}">
    <button type="submit">Yes</button>
</form>
<a href="/master/bus/schedules"><button>No</button></a>