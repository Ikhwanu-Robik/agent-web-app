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
    @include('components.header');

    <main>
        <aside id="choose_history">
            <h2>Choose Your History</h2>
            <a href="/report?service=bus-ticket">Bus Ticket</a>
            <a href="/report?service=bpjs">BPJS</a>
            <a href="">Film Ticket</a>
            <a href="">Game Top Up</a>
            <a href="">Power Top Up</a>
        </aside>


        @php
            $service = request()->query('service');
        @endphp
        @if ($service == 'bus-ticket')
            <article>
                <h1>Your Bus Ticket Transaction History</h1>

                <section id="content">
                    <ul>
                        @foreach ($bus_ticket_transactions as $transaction)
                            <li class="transaction-record">
                                <h2>{{ $transaction->busSchedule->originStation->name }} -
                                    {{ $transaction->busSchedule->destinationStation->name }} |
                                    {{ $transaction->busSchedule->bus->name }}</h2>
                                <p>{{ $transaction->ticket_amount }}
                                    ticket{{ $transaction->ticket_amount > 1 ? 's' : '' }} |
                                    Rp.{{ number_format($transaction->total, 0, ',', '.') }} |
                                    {{ $transaction->method }} |
                                    {{ $transaction->status }}</p>
                            </li>
                        @endforeach
                    </ul>
                </section>
            </article>
        @elseif ($service == 'bpjs' || isset($bpjs_transactions))
            <article>

                @if (!isset($bpjs_transactions))
                    <h2>First of all, we need to know your NIK</h2>

                    @if ($errors->any())
                        <div class="errors">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form action="/report/bpjs" method="post">
                        @csrf
                        <input type="text" name="civil_id" id="civil_id" placeholder="NIK">
                        <button type="submit">Send</button>
                    </form>
                @else
                    <h1>Your BPJS Transaction History</h1>
                    <h4>NIK : {{ $civil_information->NIK }}</h4>
                    <h4>Class : {{ $civil_information->activeBpjs->bpjsClass->class }}</h4>
                    <h4>Active until : {{ $civil_information->activeBpjs->dueDate() }}</h4>

                    <section id="content">
                        <ul>
                            @foreach ($bpjs_transactions as $transaction)
                                <li class="transaction-record">
                                    <h5>+ {{ $transaction->month_bought }}
                                        month{{ $transaction->month_bought > 1 ? 's' : '' }}</h5>
                                    <span>Rp.{{ number_format($transaction->total, 0, '.') }} |
                                        {{ $transaction->method }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </section>
                @endif
            </article>
        @else
            <article id="no-service-selected">
                <h1>Choose a service to see your transaction history</h1>
            </article>
        @endif
    </main>
</body>

</html>
