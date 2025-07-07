<h1>Add New Bus</h1>

@include('components.master.header')

<form action="/master/bus/create" method="post">
    @csrf
    <label for="name">Bus Name</label>
    <input type="text" name="name" id="name">

    <button type="submit">Add</button>
</form>
