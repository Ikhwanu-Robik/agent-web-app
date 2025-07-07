<h1>Add New BPJS Class</h1>

@include("components.master.header")

@if ($errors->any())
    <div class="errors">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<form action="/master/bpjs/prices/create" method="post">
    @csrf
    <label for="class">Class</label>
    <input type="number" name="class" id="class">
    <label for="price">Monthly pay</label>
    <input type="number" name="price" id="price">

    <button type="submit">Add</button>
</form>