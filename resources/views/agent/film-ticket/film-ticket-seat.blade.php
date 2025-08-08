<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vouchers</title>
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

        #voucher-container {
            display: flex;
            gap: 1em;
            margin: 0.5em;
        }

        .voucher {
            background-color: rgb(255, 255, 98);
            padding: 1em;
        }
    </style>
</head>

<body>
    @include('components.header')

    <main>

        <h1>Beli Tiket Film</h1>
        <h2>Pilih Kursi</h2>

        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h3>{{ $filmSchedule->film->title }}</h3>
        <span>{{ $filmSchedule->cinema->name }}</span> <br>
        <span>{{ $filmSchedule->airing_datetime }}</span> <br>
        <span>Rp.{{ number_format($filmSchedule->ticket_price, 0, '.') }}</span>

        <div id="seats">
            <span>Pilih Kursi</span>

            <form action="{{ route("film_ticket_transaction.book_seat") }}" method="post">
                @csrf
                <input type="hidden" name="cinema_film_id" value="{{ $filmSchedule->id }}">

                <table>

                    @foreach (json_decode($filmSchedule->seats_status) as $indexY => $row)
                        <tr>

                            @foreach ($row as $indexX => $col)
                                <td>
                                    <input type="checkbox" name="seat_coordinates[]"
                                        value="{{ $indexX . ',' . $indexY }}" {{ $col == 1 ? 'checked disabled' : '' }}>
                                </td>
                            @endforeach

                        </tr>
                    @endforeach

                </table>
                <button type="submit">Beli</button>

            </form>

        </div>

    </main>
</body>

</html>
