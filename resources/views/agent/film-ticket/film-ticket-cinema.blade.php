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
        <h2>Pilih Bioskop</h2>

        <ul>
            @foreach ($cinemas as $cinema)
                <li>
                    <div id="cinema">
                        <h3>{{ $cinema->name }}</h3>

                        <div id="seats">
                            <h4>Jadwal Tersedia</h4>
                            <table>

                                @foreach ($cinema->films as $schedule)
                                    <tr>
                                        <td>
                                            <form action="{{ route("film_ticket_transaction.show_book_seat_form") }}" method="get">
                                                <input type="hidden" name="cinema_film_id"
                                                    value="{{ $schedule->film_schedule->id }}">
                                                <button type="submit">Pilih</button>
                                            </form>
                                        </td>
                                        <td>
                                            <h5>{{ $schedule->title }}</h5>
                                            <img src="{{ asset($schedule->poster_image_url) }}" alt=""
                                                width="90em">
                                        </td>

                                        <td>
                                            <span>Tiket :
                                                Rp.{{ number_format($schedule->film_schedule->ticket_price, 0, '.') }}</span>
                                            <br>
                                            <span>Date : {{ $schedule->film_schedule->airing_datetime }}</span>
                                        </td>

                                        <td>
                                            <h5>Seats Availability</h5>
                                            <table>
                                                @php
                                                    $seats = json_decode($schedule->film_schedule->seats_status);
                                                @endphp
                                                @foreach ($seats as $row)
                                                    <tr>
                                                        @foreach ($row as $col)
                                                            <td>
                                                                <input type="checkbox" name="" id=""
                                                                    disabled {{ $col == 1 ? 'checked' : '' }}>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </main>
</body>

</html>
