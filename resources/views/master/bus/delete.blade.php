<h1>Are You Sure To Delete {{ $bus->name }} ?</h1>

@include('components.master.header')

<form action="{{ '/master/bus/delete/' . $bus->id }}" method="post" style="display:inline">
    @csrf
    @method('DELETE')
    <input type="hidden" name="bus" value="{{ $bus->id }}">
    <button type="submit">Yes</button>
</form>
<a href="/master/bus"><button>No</button></a>
