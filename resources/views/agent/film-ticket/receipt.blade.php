<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Film Ticket</title>
    <link rel="stylesheet" href="{{ url('/assets/receipt.css') }}">
</head>

<body>
    <div id="container">
        <div id="receipt">
            <header>
                <h1 id="transaction-status">Transaction
                    {{ $filmTicketTransaction->method == 'cash' ? 'Successful' : 'Pending' }}</h1>
                <em id="timestamp">{{ $filmTicketTransaction->created_at }}</em> <br>
            </header>

            <section>
                <div>
                    <table>
                        <tr>
                            <td>Film title</td>
                            <td>:</td>
                            <td>{{ $filmTicketTransaction->cinema_film->film->title }}</td>
                        </tr>
                        <tr>
                            <td>Cinema</td>
                            <td>:</td>
                            <td>{{ $filmTicketTransaction->cinema_film->cinema->name }}</td>
                        </tr>
                        <tr>
                            <td>Airing time</td>
                            <td>:</td>
                            <td>{{ $filmTicketTransaction->cinema_film->airing_datetime }}</td>
                        </tr>
                        <tr>
                            <td>Ticket price</td>
                            <td>:</td>
                            <td>Rp.{{ number_format($filmTicketTransaction->cinema_film->ticket_price, 0, '.') }}</td>
                        </tr>
                        <tr>
                            <td>Ticket bought</td>
                            <td>:</td>
                            <td>{{ count(json_decode($filmTicketTransaction->seats_coordinates)) }}</td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td>:</td>
                            <td>Rp.{{ number_format($filmTicketTransaction->total, 0, '.') }}</td>
                        </tr>
                        @if (session()->has('voucher'))
                            <tr>
                                <td>Voucher</td>
                                <td>:</td>
                                <td>{{ session()->get('voucher') }}</td>
                            </tr>
                        @endif
                    </table>

                    for these seats : {{ json_encode($filmTicketTransaction->seats_coordinates_array) }}
                    <table>

                        @php
                            $seatsStructure = json_decode($filmTicketTransaction->cinema_film->cinema->seats_structure);
                            $rowCount = count($seatsStructure);
                            $colCount = count($seatsStructure[0]);
                        @endphp
                        @for ($row = 0; $row < $rowCount; $row++)
                            <tr>

                                @for ($col = 0; $col < $colCount; $col++)
                                    <td>
                                        <input type="checkbox" disabled
                                            {{ array_search($col . ',' . $row, $filmTicketTransaction->seats_coordinates_array) !== false ? 'checked' : '' }}>
                                    </td>
                                @endfor

                            </tr>
                        @endfor

                    </table>
                </div>

                <h3 id="payment-method">Paid with {{ $filmTicketTransaction->method }}</h3>

                @if ($filmTicketTransaction->method == 'flip')
                    <h3>To pay with Flip, click <a href="{{ 'https://' . $flipResponse['link_url'] }}">this link</a>
                    </h3>
                @endif
            </section>

        </div>
    </div>

</body>

</html>