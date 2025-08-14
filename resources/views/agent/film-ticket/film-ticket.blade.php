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

        main #films-list {
            display: flex;
            gap: 1em;
            flex-wrap: wrap;
        }

        main .film-card {
            display: flex;
            flex-direction: column;
            gap: 0.5em;
        }
    </style>
</head>

<body>
    @include('components.header')

    <main>
        <h1>Buy Film Ticket</h1>
        <h2>Choose Film</h2>

        @if ($errors->any())
            <div>
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div id="films-list">
            @foreach ($films as $film)
                <form action="{{ route('film_ticket_transaction.find_airing_cinema', ['film' => $film->id]) }}"
                    method="post">
                    @csrf
                    <input type="hidden" name="film_id" value="{{ $film->id }}">
    
                    <button type="submit">
                        <div class="film-card">
                            <img src="{{ asset($film->poster_image_url) }}" alt="" width="150em">
                            <h4>{{ $film->title }}</h4>
                            <span>{{ $film->duration }} minutes</span>
                        </div>
                    </button>
                </form>
            @endforeach
        </div>
    </main>
</body>

</html>
