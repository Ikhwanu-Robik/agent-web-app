<h1>Choose Payment Method</h1>

<form action="/power/buy" method="post">
    @csrf
    <select name="payment_method" id="">
        <option value="cash">cash</option>
        <option value="flip">flip</option>
    </select>

    <button type="submit">Buy</button>
</form>