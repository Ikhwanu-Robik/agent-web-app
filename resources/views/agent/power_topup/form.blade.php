<h1>Beli Token Listrik</h1>

<form action="/power/payment" method="post">
    @csrf
    <label for="subscriber_number">Subsciber Number</label>
    <input type="number" name="subscriber_number" id="subscriber_number">
    <label for="nominal">Nominal (Rp.)</label>
    <input type="number" name="nominal" id="nominal" />

    <button type="submit">Buy</button>
</form>
