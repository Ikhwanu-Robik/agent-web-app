<h1>Add New Bus</h1>

<ul>
    <li><a href="/master/vouchers">Master Vouchers</a></li>
    <li><a href="/master/bus">Master Bus</a></li>
    <li><a href="/master/bus/station">Master Bus Station</a></li>
    <li><a href="/master/bus/schedules">Master Bus Schedule</a></li>
</ul>

<form action="/master/bus/create" method="post">
    @csrf
    <label for="name">Bus Name</label>
    <input type="text" name="name" id="name">

    <button type="submit">Add</button>
</form>