<h1>Edit Bus</h1>

<form action="{{ "/master/bus/edit/" . $bus->id }}" method="post">
    @csrf
    @method("PUT")
    <label for="name">Bus Name</label>
    <input type="text" name="name" id="name" value="{{ $bus->name }}">
    
    <button type="submit">Save</button>
</form>