<h1>Are You Sure To Delete Class {{ $bpjs_price->class }} of BPJS?</h1>

<ul>
    <li><a href="/master/vouchers">Master Vouchers</a></li>
    <li><a href="/master/bus">Master Bus</a></li>
    <li><a href="/master/bus/station">Master Bus Station</a></li>
    <li><a href="/master/bus/schedules">Master Bus Schedule</a></li>
</ul>

@if ($errors->any())
    <div class="errors">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<form action="{{ "/master/bpjs/prices/delete/" . $bpjs_price->id }}" method="post" style="display:inline">
    @csrf
    @method("DELETE")
    <input type="hidden" name="bpjs_price" value="{{ $bpjs_price->id }}">
    <button type="submit">Yes</button>
</form>
<a href="/master/bpjs/prices"><button>No</button></a>