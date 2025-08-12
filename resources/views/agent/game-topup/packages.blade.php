<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Game Top Up</title>
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
    </style>
</head>

<body>
    @include('components.header')

    <main>
        <h1>Top Up Game</h1>
        <h2>Choose Game</h2>

        <form action="{{ route("game_top_up_transaction.find_game_packages") }}" method="post">
            @csrf
            <select name="game_id" id="">
                @foreach ($games as $game)
                    <option value="{{ $game->id }}">{{ $game->name }}</option>
                @endforeach
            </select>
            <button type="submit">Search Top Up Packages</button>
        </form>

        @if ($packages)
            <div>
                <ul>
                    @foreach ($packages as $package)
                        <li>
                            <div>
                                <h3>{{ $package->title }}</h3>
                                <span>{{ $package->game->name }}</span> <br>
                                <em>{{ $package->items_count }} {{ $package->game->currency }} -
                                    Rp. {{ number_format($package->price, 0, ",", ".") }}</em>
                                <form action="{{ route("game_top_up_transaction.order_package", ["package" => $package->id]) }}" method="post">
                                    @csrf
                                    <input type="hidden" name="game_id" value="{{ $selectedGameId }}">
                                    <input type="hidden" name="game_top_up_package_id" value="{{ $package->id }}">
                                    <button type="submit">Buy</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </main>
</body>

</html>
