<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bus Ticket</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: sans-serif;
        }

        #container {
            width: 100vw;
            height: 100vh;
            display: flex;
            justify-content: center;
            background-color: rgb(207, 207, 207);
        }

        #receipt {
            height: 100vh;
            width: 30vw;
            display: flex;
            flex-direction: column;
            align-items: center;
            border-radius: 1em;
            padding: 2em;
        }

        header {
            background-color: rgb(0, 136, 255);
            width: 28vw;
            height: 8em;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border-top-left-radius: 1em;
            border-top-right-radius: 1em;
        }

        #transaction-status, #timestamp {
            color: rgb(255, 255, 255);
        }

        section {            
            display: flex;
            width: 28vw;    
            height: 70vh;
            background-color: rgb(255, 255, 255);
            flex-direction: column;
            align-items: center;
            padding: 1em;
            gap: 1em;
            border-bottom-left-radius: 1em;
            border-bottom-right-radius: 1em;
        }
    </style>
</head>

<body>
    <div id="container">
        <div id="receipt">
            <header>
                <h1 id="transaction-status"></h1>
                <em id="timestamp"></em> <br>
            </header>

            <section>
                <h2></h2>

                <div>
                    <h4>From JKT To
                        BND</h4>
                    <h4>Depart at 2025-09-11 23:07:42</h4>
                    <span>1 Ticket</span> <br>
                    <h3>Rp. 60.000</h3>
                    @if ($transaction->voucher)
                        <span>Voucher : 5% OFF</span>
                    @endif
                </div>

                <h3 id="payment-method">Paid with cash</h3>

                @if ($paymentMethod == 'flip')
                    <h3>To pay with Flip, click <a href="">this link</a></h3>
                @endif
            </section>
        </div>
    </div>
</body>

</html>
