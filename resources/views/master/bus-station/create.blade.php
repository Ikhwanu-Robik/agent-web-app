<h1>Add New Bus Station</h1>

@include("components.master.header")

<form action="/master/bus/station/create" method="post">
    @csrf
    <label for="name">Station Name</label>
    <input type="text" name="name" id="name">

    <button type="submit">Add</button>
</form>