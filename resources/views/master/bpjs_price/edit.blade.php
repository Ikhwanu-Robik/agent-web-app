<h1>Edit Bus</h1>

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

<form action="{{ "/master/bpjs/prices/edit/" . $bpjs_price->id }}" method="post">
    @csrf
    @method("PUT")
    <label for="class">Class</label>
    <input type="number" name="class" id="class" value="{{ $bpjs_price->class }}">
    <label for="price">Monthy pay</label>
    <input type="number" name="price" id="price" value="{{ $bpjs_price->price }}">
    
    <button type="submit">Save</button>
</form>