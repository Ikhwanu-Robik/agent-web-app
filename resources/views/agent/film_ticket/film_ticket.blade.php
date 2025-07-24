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
    <h2>Pilih Film</h2>

    @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="/film/cinema" method="post">
        @csrf
        <section id="find-cinema">
            <label for="film">Judul Film</label>
            <select name="film_id" id="film">
                @foreach ($films as $film)
                    <option value="{{ $film->id }}">{{ $film->title }}</option>
                @endforeach
            </select>

            <button type="submit">Cari Bioskop</button>
        </section>
    </form>
</body>

</html>
