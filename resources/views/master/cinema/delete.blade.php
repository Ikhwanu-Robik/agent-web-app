<h1>Are You Sure To Delete {{ $cinema->name }} Cinema?</h1>

@include('components.master.header')

<form action="{{ "/master/cinemas/delete/" . $cinema->id }}" method="post" style="display:inline">
    @csrf
    @method("DELETE")
    <input type="hidden" name="cinema" value="{{ $cinema->id }}">
    <button type="submit">Yes</button>
</form>
<a href="/master/cinemas"><button>No</button></a>
