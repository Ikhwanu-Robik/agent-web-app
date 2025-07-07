<h1>Edit Bus</h1>

<ul>
    <li><a href="/master/vouchers">Master Vouchers</a></li>
    <li><a href="/master/bus">Master Bus</a></li>
    <li><a href="/master/bus/station">Master Bus Station</a></li>
    <li><a href="/master/bus/schedules">Master Bus Schedule</a></li>
</ul>

<form action="{{ "/master/bus/edit/" . $bus->id }}" method="post">
    @csrf
    @method("PUT")
    <label for="name">Bus Name</label>
    <input type="text" name="name" id="name" value="{{ $bus->name }}">
    
    <button type="submit">Save</button>
</form>