<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report {{ $service }}</title>
</head>

<body>
    @if ($service == 'film-ticket')
        <table>
            <thead>
                <tr>
                    <th style="font-weight: bold">Film Title</th>
                    <th style="font-weight: bold">Cinema</th>
                    <th style="font-weight: bold">Transaction Date</th>
                    <th style="font-weight: bold">Ticket Price</th>
                    <th style="font-weight: bold">Quantity</th>
                    <th style="font-weight: bold">Seats</th>
                    <th style="font-weight: bold">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $transaction)
                    @php
                        $seats_coordinates = json_decode($transaction->seats_coordinates);
                        $ticket_qty = count($seats_coordinates);
                    @endphp
                    <tr>
                        <td rowspan="{{ $ticket_qty }}" style="vertical-align: middle">{{ $transaction->cinemaFilm->film->title }}</td>
                        <td rowspan="{{ $ticket_qty }}" style="vertical-align: middle">{{ $transaction->cinemaFilm->cinema->name }}</td>
                        <td rowspan="{{ $ticket_qty }}" style="vertical-align: middle">{{ $transaction->created_at }}</td>
                        <td rowspan="{{ $ticket_qty }}" style="vertical-align: middle">
                            {{ $transaction->cinemaFilm->ticket_price }}</td>
                        <td rowspan="{{ $ticket_qty }}" style="vertical-align: middle">
                            {{ $ticket_qty }}
                        </td>
                        <td>
                            {{ $seats_coordinates[0] }}
                        </td>
                        <td rowspan="{{ $ticket_qty }}" style="vertical-align: middle">
                            {{ $transaction->total }}
                        </td>
                    </tr>
                    @if ($ticket_qty > 1)
                        @for ($i = 1; $i < $ticket_qty; $i++) 
                            <tr>
                                <td>
                                    {{ $seats_coordinates[$i] }}
                                </td>
                            </tr>
                        @endfor
                    @endif
                @endforeach
            </tbody>
        </table>
    @endif
</body>

</html>
