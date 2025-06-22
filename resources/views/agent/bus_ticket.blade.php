<h1>Beli Tiket Bus</h1>

<form action="/bus-ticket" method="post">
    @csrf

    <label for="departure-date">Tanggal Berangkat</label>
    <input type="date" name="departure-date" id="departure-date">
    <label for="departure-time">Jam Berangkat</label>
    <input type="time" name="departure-time" id="departure-time">

    <br>

    <label for="origin">Dari</label>
    <select name="origin" id="origin">
        <option value=""></option>
    </select>
    <label for="destination">Tujuan</label>
    <select name="destination" id="destination">
        <option value=""></option>
    </select>
    <label for="ticket-amount">Jumlah Tiket</label>
    <input type="number" name="ticket_amount" id="ticket-amount" min="1" value="1">

    <button type="submit">Pesan</button>
</form>
