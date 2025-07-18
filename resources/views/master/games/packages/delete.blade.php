<h1>Are You Sure To Delete {{ $package->title }}?</h1>

@include('components.master.header')

<form action="{{ "/master/games/packages/delete/" . $package->id }}" method="post" style="display:inline">
    @csrf
    @method("DELETE")
    <input type="hidden" name="package" value="{{ $package->id }}">
    <button type="submit">Yes</button>
</form>
<a href="/master/games/packages"><button>No</button></a>
