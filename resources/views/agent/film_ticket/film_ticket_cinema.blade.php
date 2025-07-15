<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Film Ticket</title>
</head>

<body>
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
                                        <form action="/film/cinema/seats" method="get">
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

</body>

</html>
