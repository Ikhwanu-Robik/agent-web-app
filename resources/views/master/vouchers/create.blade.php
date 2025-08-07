<h1>Add New Voucher</h1>

@include('components.master.header')

@foreach ($errors->all() as $error)
    {{ $error }} <br />
@endforeach

<form action="/master/vouchers/create" method="post">
    @csrf
    <label for="discount">Off Percentage</label>
    <input type="number" name="off_percentage" id="discount" max="100"> <br>
    <label for="valid_for">Valid for : </label>
    <ul>
        @foreach ($validServices as $service)
            <li>
                <label for="{{ $service }}">{{ $service }}</label>
                <input type="checkbox" name="valid_for[]" id="{{ $service }}" value="{{ $service }}" multiple>
            </li>
        @endforeach
    </ul>
    <label for="user_id">User</label>
    <select name="user_id" id="user_id">
        @foreach ($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
    </select>

    <button type="submit">Add</button>
</form>
