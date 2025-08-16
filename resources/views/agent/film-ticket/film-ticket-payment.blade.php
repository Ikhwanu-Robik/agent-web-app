<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Film Ticket</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: sans-serif;
        }

        header {
            width: 100vw;
            height: 10vh;
            background-color: rgb(37, 104, 175);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2em;
        }

        header>div {
            height: 100%;
            display: flex;
            align-items: center;
            gap: 1em;
        }

        header>div>#profile_photo:hover+#username {
            display: block;
        }

        header>div>#username {
            position: absolute;
            top: 4em;
            left: 1em;
            background-color: white;
            padding: 0.1em;
            border: 1px solid black;
            border-radius: 5%;
            display: none;
        }

        header>div>#profile_photo {
            height: 80%;
            border-radius: 50%
        }

        header>div>.nav-button {
            text-decoration: none;
            padding: 1em;
            color: white;
            font-weight: bold;
        }

        header>div>.nav-button:hover {
            background-color: rgb(15, 80, 151);
        }

        header>form>#logout-button {
            padding: 0.5em 1em;
            font-weight: bold;
            color: white;
            background-color: rgb(10, 60, 114);
            border: none;
        }

        main {
            padding: 3em;
            display: flex;
            flex-direction: column;
            gap: 1em;
        }

        main input,
        main button,
        main select {
            padding: 0.2em;
        }

        main button {
            background-color: rgb(0, 128, 255);
            color: white;
            border: none;
            padding: 0.5em;
        }

        main button:hover {
            background-color: rgb(0, 200, 255);
        }

        main table {
            display: block;
        }
    </style>
</head>

<body>
    @include('components.header')

    <main>
        <h1>Choose Payment Method</h1>

        @if ($errors->any())
            <div class="error" style="color:red">
                @foreach ($errors->all() as $error)
                    <div>
                        {{ $error }}
                    </div>
                @endforeach
            </div>
        @endif

        <h2>You are about to buy a film ticket :</h2>
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
        </table>

        for these seats :
        {{ json_encode($seatCoordinates) }}
        <table>

            @php
                $seatsStructure = json_decode($filmTicketTransaction->cinema_film->seats_status);
                $rowCount = count($seatsStructure);
                $colCount = count($seatsStructure[0]);
            @endphp
            @for ($row = 0; $row < $rowCount; $row++)
                <tr>

                    @for ($col = 0; $col < $colCount; $col++)
                        <td>
                            <input type="checkbox" disabled
                                {{ array_search($col . ',' . $row, $seatCoordinates) !== false ? 'checked' : '' }}>
                        </td>
                    @endfor

                </tr>
            @endfor

        </table>

        <form
            action="{{ route('film_ticket_transaction.pay', [
                'film' => $filmTicketTransaction->cinema_film->film->id,
                'cinema' => $filmTicketTransaction->cinema_film->cinema->id,
                'schedule' => $filmTicketTransaction->cinema_film->id,
            ]) }}"
            method="post">
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
                    <option value="{{ $voucher->id }}">{{ $voucher->off_percentage }}% - @foreach (json_decode($voucher->valid_for) as $validService)
                            {{ $validService }},
                        @endforeach
                    </option>
                @endforeach
            </select>
            <button type="submit">Pay</button>
        </form>

    </main>
</body>

</html>
