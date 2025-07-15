<h1>{{ $cinemaWithFilms->name }}</h1>

<a href="{{ '/master/cinemas/' . $cinemaWithFilms->id . '/films/schedule' }}"><button>Schedule Film Airing</button></a>

@if (count($cinemaWithFilms->films) != 0)
    <h2>List of Film</h2>
    <table>
        @foreach ($cinemaWithFilms->films as $film)
            <tr>
                <td>
                    <img src="{{ asset($film->poster_image_url) }}" alt="" width="150em">
                </td>
                <td>
                    <h3>{{ $film->title }}</h3>
                    <span>{{ $film->duration }} minutes</span> <br>
                    <span>Tiket : Rp.{{ number_format($film->film_schedule->ticket_price, 0, '.') }}</span> <br>
                    <span>{{ $film->film_schedule->airing_datetime }}</span>
                </td>
                <td>
                    <h4>Seats Status</h4>
                    <table>
                        @foreach (json_decode($film->film_schedule->seats_status) as $row)
                            <tr>
                                @foreach ($row as $col)
                                    <td>
                                        <input type="checkbox" name="" id="" {{ $col == 1 ? 'checked' : '' }}
                                            disabled>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </table>
                    <form
                        action="{{ '/master/cinemas/' . $cinemaWithFilms->id . '/films/schedule/' . $film->film_schedule->id }}"
                        method="post">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="schedule_id" value="{{ $film->film_schedule->id }}">
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@else
    <h2>No films in schedule</h2>
@endif
