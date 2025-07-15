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

    <h3>{{ $film_schedule->film->title }}</h3>
    <span>{{ $film_schedule->cinema->name }}</span> <br>
    <span>{{ $film_schedule->airing_datetime }}</span> <br>
    <span>Rp.{{ number_format($film_schedule->ticket_price, 0, '.') }}</span>

    <div id="seats">
        <span>Pilih Kursi</span>

        <form action="/film/cinema/seats/book" method="post">
            @csrf
            <input type="hidden" name="cinema_film_id" value="{{ $film_schedule->id }}">

            <table>

                @foreach (json_decode($film_schedule->seats_status) as $indexY => $row)
                    <tr>

                        @foreach ($row as $indexX => $col)
                            <td>
                                <input type="checkbox" name="seat_coordinates[]" value="{{ $indexX . ',' . $indexY }}"
                                    {{ $col == 1 ? 'checked disabled' : '' }}>
                            </td>
                        @endforeach

                    </tr>
                @endforeach

            </table>
            <button type="submit">Beli</button>

        </form>

    </div>

</body>

</html>
