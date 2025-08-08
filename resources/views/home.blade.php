<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
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
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        main>#services {
            width: 70%;
            margin: 1em;
            background-color: rgb(240, 240, 240);
            padding: 1em;
        }

        main>#services>ul {
            display: flex;
            justify-content: space-between;
            list-style: none;
        }

        main>#services>ul>li {
            height: 8em;
            width: 8em;
        }

        main>#services>ul>li>a {
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: black;
        }

        main>#services>ul>li>a>img {
            background-color: rgb(119, 195, 227);
            padding: 1em;
            border-radius: 15%;
            width: 80%;
        }

        #dashboard {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #dashboard>.statistics {
            width: 90%;
            background-color: rgb(0, 136, 255);
            color: white;
            padding: 2em;
        }

        #dashboard>.statistics>h1 {
            font-size: 2em;
        }

        #dashboard>.statistics #transaction-record, #game-count, #money-spent {
            font-size: 3em;
        }

        #dashboard>.statistics #most-bought-service {
            text-decoration: underline;
        }

        #dashboard>.charts {
            width: 50%;
            align-self: flex-start;
            margin-left: 5vw;
            margin-top: 2em;
            padding: 2em;
            background-color: rgb(0, 94, 176);
            color: white;
        }

        #dashboard>.charts>.bar {
            background-color: white;
            height: 0.5em;
        }

        #dashboard>.charts>.bus, .electric, .film {
            width: 0.2em;
        }

        #dashboard>.charts>.bpjs {
            width: 5em;
        }

        #dashboard>.charts>.top-up-game {
            width: 18em;
        }
    </style>
</head>

<body>
    @include("components.header")

    <main>
        <section id="services">
            <h2>What to do?</h2>
            <ul>
                <li><a href="{{ route("bus_ticket_transaction.select_schedule") }}"><img src="{{ config('app.url') . '/assets/bus_icon.png' }}"
                            alt="">Tiket Bus</a></li>
                <li><a href="{{ route("bpjs_transaction.form") }}"><img src="{{ config('app.url') . '/assets/bpjs.png' }}" alt="">Bayar
                        BPJS</a></li>
                <li><a href="{{ route("film_ticket_transaction.select_film") }}"><img src="{{ config('app.url') . '/assets/cinema_icon.png' }}"
                            alt="">Tiket Film</a></li>
                <li><a href="{{ route("game_top_up_transaction.select_game") }}"><img src="{{ config('app.url') . '/assets/game_icon.png' }}"
                            alt="">Top up Game</a></li>
                <li><a href="{{ route("power_top_up_transaction.form") }}"><img src="{{ config('app.url') . '/assets/electricity_icon.png' }}"
                            alt="">Isi token listrik</a></li>
            </ul>
        </section>
        <section id="dashboard">
            <article class="statistics">
                <h1>Transaction of the Month : <span id="most-bought-service">{{ $transactionOfTheMonth["service"] }}</span></h1>
                <span><span id="transaction-record">{{ $transactionOfTheMonth["record_count"] }}</span> transaction records</span>
                <span><span id="money-spent">Rp{{ number_format($transactionOfTheMonth["money_spent"], 2, ",", ".") }}</span>money spent </span>
            </article>
        </section>
    </main>
</body>

</html>
