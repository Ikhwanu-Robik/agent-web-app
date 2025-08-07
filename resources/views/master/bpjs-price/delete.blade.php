<h1>Are You Sure To Delete Class {{ $bpjsPrice->class }} of BPJS?</h1>

@include("components.master.header")

@if ($errors->any())
    <div class="errors">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<form action="{{ "/master/bpjs/prices/delete/" . $bpjsPrice->id }}" method="post" style="display:inline">
    @csrf
    @method("DELETE")
    <input type="hidden" name="bpjs_price" value="{{ $bpjsPrice->id }}">
    <button type="submit">Yes</button>
</form>
<a href="/master/bpjs/prices"><button>No</button></a>