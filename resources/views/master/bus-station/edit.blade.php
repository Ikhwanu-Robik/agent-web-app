<h1>Edit Bus Station</h1>

@include("components.master.header")

<form action="{{ "/master/bus/station/edit/" . $busStation->id }}" method="post">
    @csrf
    @method("PUT")
    <label for="name">Station Name</label>
    <input type="text" name="name" id="name" value="{{ $busStation->name }}">
    
    <button type="submit">Save</button>
</form>