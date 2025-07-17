<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Film Ticket</title>
</head>

<h1>Choose Payment Method</h1>
<h2>You are about to buy a film ticket :</h2>
<table>
    <tr>
        <td>Film title</td>
        <td>:</td>
        <td>{{ $film_ticket_transaction->cinema_film->film->title }}</td>
    </tr>
    <tr>
        <td>Cinema</td>
        <td>:</td>
        <td>{{ $film_ticket_transaction->cinema_film->cinema->name }}</td>
    </tr>
    <tr>
        <td>Airing time</td>
        <td>:</td>
        <td>{{ $film_ticket_transaction->cinema_film->airing_datetime }}</td>
    </tr>
    <tr>
        <td>Ticket price</td>
        <td>:</td>
        <td>Rp.{{ number_format($film_ticket_transaction->cinema_film->ticket_price, 0, '.') }}</td>
    </tr>
    <tr>
        <td>Ticket bought</td>
        <td>:</td>
        <td>{{ count(json_decode($film_ticket_transaction->seats_coordinates)) }}</td>
    </tr>
    <tr>
        <td>Total</td>
        <td>:</td>
        <td>Rp.{{ number_format($film_ticket_transaction->total, 0, '.') }}</td>
    </tr>
</table>

for these seats :
{{ json_encode($seat_coordinates) }}
<table>

    @php
        $seats_structure = json_decode($film_ticket_transaction->cinema_film->cinema->seats_structure);
        $rowCount = count($seats_structure);
        $colCount = count($seats_structure[0]);
    @endphp
    @for ($row = 0; $row < $rowCount; $row++)
        <tr>

            @for ($col = 0; $col < $colCount; $col++)
                <td>
                    <input type="checkbox" disabled
                        {{ array_search($col . ',' . $row, $seat_coordinates) !== false ? 'checked' : '' }}>
                </td>
            @endfor

        </tr>
    @endfor

</table>
</body>

<form action="/film/cinema/transaction" method="post">
    @csrf
    <label for="payment_method">Payment Method</label>
    <select name="payment_method" id="payment_method">
        <option value="cash">Cash</option>
        <option value="flip">Flip</option>
    </select>
    <label for="voucher">Voucher</label>
    <select name="voucher" id="voucher">
        <option value="-1">No Voucher</option>
        @foreach ($vouchers as $voucher)
            <option value="{{ $voucher->id }}">{{ $voucher->off_percentage }}% - @foreach (json_decode($voucher->valid_for) as $valid_service)
                    {{ $valid_service }},
                @endforeach
            </option>
        @endforeach
    </select>
    <button type="submit">Pay</button>
</form>

</html>
