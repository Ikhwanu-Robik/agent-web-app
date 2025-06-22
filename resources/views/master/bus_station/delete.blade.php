<h1>Are You Sure To Delete {{ $bus_station->name }} ?</h1>

<form action="{{ "/master/bus/station/delete/" . $bus_station->id }}" method="post" style="display:inline">
    @csrf
    @method("DELETE")
    <input type="hidden" name="bus_station" value="{{ $bus_station->id }}">
    <button type="submit">Yes</button>
</form>
<a href="/master/bus/station"><button>No</button></a>