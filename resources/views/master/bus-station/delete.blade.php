<h1>Are You Sure To Delete {{ $busStation->name }} ?</h1>

@include("components.master.header")

<form action="{{ "/master/bus/station/delete/" . $busStation->id }}" method="post" style="display:inline">
    @csrf
    @method("DELETE")
    <input type="hidden" name="bus_station" value="{{ $busStation->id }}">
    <button type="submit">Yes</button>
</form>
<a href="/master/bus/station"><button>No</button></a>