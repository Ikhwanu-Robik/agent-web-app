<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Film Ticket</title>
</head>

<h1>Transaction {{ $film_ticket_transaction->payment_method = 'cash' ? 'Successful' : 'Pending' }}</h1>
<h2>You have bought a film ticket with the following data : </h2>
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
    <tr>
        <td>Payment Method</td>
        <td>:</td>
        <td>{{ $film_ticket_transaction->payment_method }}</td>
    </tr>
    <tr>
        <td>Payment Status</td>
        <td>:</td>
        <td>{{ $film_ticket_transaction->status }}</td>
    </tr>
    @if (session()->has('voucher'))
        <tr>
            <td>Voucher</td>
            <td>:</td>
            <td>{{ session()->get('voucher') }}</td>
        </tr>
    @endif
</table>

for these seats : {{ json_encode($film_ticket_transaction->seats_coordinates_array) }}
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
                        {{ array_search($col . ',' . $row, $film_ticket_transaction->seats_coordinates_array) !== false ? 'checked' : '' }}>
                </td>
            @endfor

        </tr>
    @endfor

</table>

@if ($film_ticket_transaction->payment_method == 'flip')
    <h3>To pay with Flip, click <a href="{{ 'https://' . $flipResponse['link_url'] }}">this link</a></h3>
@endif
</body>
