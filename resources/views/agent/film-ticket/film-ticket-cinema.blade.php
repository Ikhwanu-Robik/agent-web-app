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

        main .schedule-list {
            display: flex;
            gap: 1em;
        }

        main .schedule-data {
            font-size: 14px;
        }

        main .schedule-data h5 {
            font-size: large;
        }
    </style>
</head>

<body>
    @include('components.header')

    <main>
        <h1>Buy Film Ticket</h1>
        <h2>Choose Cinema</h2>

        <ul>
            @foreach ($cinemas as $cinema)
                <li>
                    <div id="cinema">
                        <h3>{{ $cinema->name }}</h3>

                        <div id="seats">
                            <h4>Available Schedule</h4> <br> <br>

                            <div class="schedule-list">
                                @foreach ($cinema->schedules as $schedule)
                                    <form
                                        action="{{ route('film_ticket_transaction.show_book_seat_form', [
                                            'film' => $schedule->film_id,
                                            'cinema' => $cinema->id,
                                            'schedule' => $schedule->id
                                        ]) }}"
                                        method="get">
                                        <button type="submit">
                                            <div class="schedule-data">
                                                <div>

                                                    <h5>{{ $schedule->title }}</h5>
                                                    <img src="{{ asset($schedule->poster_image_url) }}" alt=""
                                                        width="90em">
                                                </div>

                                                <span>Ticket :
                                                    Rp.{{ number_format($schedule->ticket_price, 0, '.') }}</span>
                                                <br>
                                                <span>Airing at : {{ $schedule->airing_datetime }}</span>
                                                <h5>Seats Availability</h5>
                                                <table>
                                                    @php
                                                        $seats = json_decode($schedule->seats_status);
                                                    @endphp
                                                    @foreach ($seats as $row)
                                                        <tr>
                                                            @foreach ($row as $col)
                                                                <td>
                                                                    <input type="checkbox" disabled
                                                                        {{ $col == 1 ? 'checked' : '' }}>
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                        </button>
                                    </form>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </main>
</body>

</html>
