<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Transaction History</title>
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
            height: 90vh;
        }

        main>#choose_history {
            width: 20vw;
            display: flex;
            flex-direction: column;
            background-color: rgb(15, 80, 151);
            margin: 2em;
            padding: 1em;
            color: white;
            gap: 0.5em;
        }

        main>#choose_history>h2 {
            background-color: rgb(10, 60, 114);
            padding: 0.5em 0.5em 0.2em 0.5em;
        }

        main>#choose_history a {
            color: white;
            text-decoration: none;
        }

        main>#choose_history a:hover {
            text-decoration: underline;
        }

        main>article {
            width: 80vw;
            padding: 1em;
        }

        main ul {
            list-style: none;
            margin: 0.5em;
            overflow-y: auto;
        }

        main .transaction-record {
            background-color: rgb(35, 106, 181);
            padding: 1em;
            color: white;
            margin: 0 0 0.5em 0;
        }

        main #no-service-selected {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>
    @include('components.header')

    <main>
        <aside id="choose_history">
            <h2>Choose Your History</h2>
            <a href="/report?service=bus-ticket">Bus Ticket</a>
            <a href="/report?service=bpjs">BPJS</a>
            <a href="/report?service=film-ticket">Film Ticket</a>
            <a href="/report?service=game-top-up">Game Top Up</a>
            <a href="/report?service=power-top-up">Power Top Up</a>
        </aside>

        <article>
            @if ($service && $reports)
                <a href="{{ route('report', ['export' => 'xlsx', 'service' => $service]) }}">
                    <button>Export to Excel</button>
                </a>
                <a href="{{ route('report', ['export' => 'pdf', 'service' => $service]) }}">
                    <button>Export to PDF</button>
                </a>
            @endif
            @if ($service == 'bus-ticket')
                <section id="content">
                    <ul>
                        @foreach ($reports as $transaction)
                            <li class="transaction-record">
                                <h2>{{ $transaction->busSchedule->originStation->name }} -
                                    {{ $transaction->busSchedule->destinationStation->name }} |
                                    {{ $transaction->busSchedule->bus->name }}</h2>
                                <p>{{ $transaction->ticket_amount }}
                                    ticket{{ $transaction->ticket_amount > 1 ? 's' : '' }} |
                                    Rp.{{ number_format($transaction->total, 0, ',', '.') }} |
                                    {{ $transaction->method }} |
                                    {{ $transaction->status }}</p>
                                <span>{{ $transaction->created_at }}</span>
                            </li>
                        @endforeach
                    </ul>
                </section>
            @elseif ($service == 'bpjs')
                @if ($reports == null)
                    <h2>First of all, we need to know your NIK</h2>

                    @if ($errors->any())
                        <div class="errors">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('report.find_bpjs_report') }}" method="post">
                        @csrf
                        <input type="text" name="civil_id" id="civil_id" placeholder="NIK">
                        <button type="submit">Send</button>
                    </form>
                @else
                    @php
                        $bpjsTransactions = $reports;
                        $civilInformation = $reports->civil_information;
                    @endphp

                    <h4>NIK : {{ $civilInformation->NIK }}</h4>
                    <h4>Class : {{ $civilInformation->activeBpjs->bpjsClass->class }}</h4>
                    <h4>Active until : {{ $civilInformation->activeBpjs->dueDate() }}</h4>

                    <section id="content">
                        <ul>
                            @foreach ($bpjsTransactions as $transaction)
                                <li class="transaction-record">
                                    <span>{{ $transaction->created_at }}</span>
                                    <h5>+ {{ $transaction->month_bought }}
                                        month{{ $transaction->month_bought > 1 ? 's' : '' }}</h5>
                                    <span>Rp.{{ number_format($transaction->total, 0, '.') }} |
                                        {{ $transaction->method }} | {{ $transaction->status }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </section>
                @endif
            @elseif($service == 'film-ticket')
                <section id="content">
                    <ul>
                        @foreach ($reports as $transaction)
                            <li class="transaction-record">
                                <h2>{{ $transaction->cinemaFilm->film->title }} -
                                    {{ $transaction->cinemaFilm->cinema->name }}</h2>
                                <span>{{ $transaction->created_at }}</span> <br>
                                <span>Total : Rp.{{ number_format($transaction->total, 0, '.') }}</span> <br>
                                <span>Ticket price :
                                    Rp.{{ number_format($transaction->cinemaFilm->ticket_price) }}</span> <br>
                                <span>Seats :
                                    {{ $transaction->seats_coordinates }}
                                </span>
                                <span>
                                    Method: {{ $transaction->method }}
                                </span>
                                <span>
                                    Status: {{ $transaction->status }}
                                </span>
                                <br>
                            </li>
                        @endforeach
                    </ul>
                </section>
            @elseif($service == 'game-top-up')
                <section id="content">
                    <ul>
                        @foreach ($reports as $transaction)
                            <li class="transaction-record">
                                <h2>{{ $transaction->topUpPackage->title }} -
                                    {{ $transaction->topUpPackage->game->name }}</h2>
                                <span>{{ $transaction->created_at }}</span> <br>
                                <span>Total : Rp.{{ number_format($transaction->total, 0, '.') }}</span> <br>
                                <span>
                                    {{ $transaction->method }} - {{ $transaction->status }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </section>
            @elseif($service == 'power-top-up')
                @if ($reports == null)
                    <h2>First of all, we need to know your Power Subscriber Number</h2>

                    @if ($errors->any())
                        <div class="errors">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('report.find_power') }}" method="post">
                        @csrf
                        <input type="text" name="subscriber_number" id="subscriber_number"
                            placeholder="power subscriber number">
                        <button type="submit">Send</button>
                    </form>
                @else
                    <h4>NIK : {{ $reports[0]->subscriber_number }}</h4>

                    <section id="content">
                        <ul>
                            @foreach ($reports as $transaction)
                                <li class="transaction-record">
                                    <h5>Rp.{{ number_format($transaction->total, 0, '.') }} |
                                        {{ $transaction->method }} | {{ $transaction->status }}</h5>
                                    <span>{{ $transaction->created_at }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </section>
                @endif
            @else
                <article id="no-service-selected">
                    <h1>Choose a service to see your transaction history</h1>
                </article>
            @endif
        </article>
    </main>
</body>

</html>
