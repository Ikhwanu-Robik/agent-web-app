<h1>Edit Bus Station</h1>

<form action="{{ "/master/bus/station/edit/" . $bus_station->id }}" method="post">
    @csrf
    @method("PUT")
    <label for="name">Station Name</label>
    <input type="text" name="name" id="name" value="{{ $bus_station->name }}">
    
    <button type="submit">Save</button>
</form>