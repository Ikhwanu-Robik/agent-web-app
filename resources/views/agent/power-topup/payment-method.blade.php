<h1>Choose Payment Method</h1>

<form action="/power/buy" method="post">
    @csrf
    <label for="payment_method">Payment Method</label>
    <select name="payment_method" id="payment_method">
        <option value="cash">cash</option>
        <option value="flip">flip</option>
    </select>
    <label for="voucher">Voucher</label>
    <select name="voucher" id="voucher">
        <option value="-1">No Voucher</option>
        @foreach ($vouchers as $voucher)
            <option value="{{ $voucher->id }}">{{ $voucher->off_percentage }}%</option>
        @endforeach
    </select>   

    <button type="submit">Buy</button>
</form>