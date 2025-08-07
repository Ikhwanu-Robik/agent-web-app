<h1>Edit Voucher</h1>

@include("components.master.header")

@foreach ($errors->all() as $error)
    {{ $error }} <br />
@endforeach

<form action="{{ '/master/vouchers/edit/' . $voucher->id }}" method="post">
    @csrf
    @method('PUT')
    <label for="discount">Off Percentage</label>
    <input type="number" name="off_percentage" id="discount" max="100" value="{{ $voucher->off_percentage }}"> <br>
    <label for="valid_for">Valid for : </label>
    <ul>
        @foreach ($validServices as $service)
            <li>
                <label for="{{ $service }}">{{ $service }}</label>
                <input type="checkbox" name="valid_for[]" id="{{ $service }}" value="{{ $service }}" multiple
                @php
                foreach (json_decode($voucher->valid_for) as $value) {
                    if ($value == $service) {
                        echo "checked";
                        break;
                    }
                }
                @endphp>
            </li>
        @endforeach
    </ul>
    <label for="user_id">User</label>
    <select name="user_id" id="user_id">
        @foreach ($users as $user)
            <option value="{{ $user->id }}" {{ $user->id == $voucher->user_id ? 'selected' : '' }}>
                {{ $user->name }}</option>
        @endforeach
    </select>

    <button type="submit">Save</button>
</form>
