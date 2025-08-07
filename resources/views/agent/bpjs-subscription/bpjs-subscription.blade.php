<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vouchers</title>
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

        #voucher-container {
            display: flex;
            gap: 1em;
            margin: 0.5em;
        }

        .voucher {
            background-color: rgb(255, 255, 98);
            padding: 1em;
        }
    </style>
</head>

<body>
    @include('components.header')

    <main>
        <h1>Bayar BPJS</h1>

        <h2>Cari tahu masa aktif BPJS mu</h2>

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div>
                    {{ $error }}
                </div>
            @endforeach
        @endif

        <form action="" method="POST">
            @csrf
            <label for="civil-id">NIK</label>
            <input type="number" name="civil_id" id="civil-id" value="{{ $bpjs ? $bpjs->civilInformation->NIK : '' }}">
            <button type="submit">Cari data BPJS</button>
        </form>

        @if ($bpjs)
            <section id="bpjs-active-status">
                @if ($bpjs->isStillActive())
                    Kamu BPJS kelas {{ $bpjs->bpjsClass->class }}, dengan biaya bulanan
                    Rp.{{ number_format($bpjs->bpjsClass->price, 0, '.') }}. Kamu sudah membayar BPJS sampai
                    {{ $bpjs->dueDate()->monthName . ' ' . $bpjs->dueDate()->year }}
                @else
                    Kamu tidak memiliki langganan BPJS yang aktif
                @endif
            </section>
            <h2>Bayar BPJS</h2>
        @else
            <h2>atau langsung berlangganan</h2>
        @endif

        <form action="/bpjs/pay" method="post">
            @csrf
            @if (isset($bpjs))
                <input type="hidden" name="civil_id" value="{{ $bpjs->civilInformation->NIK }}">
            @else
                <label for="civil-id">NIK</label>
                <input type="number" name="civil_id" id="civil-id">
            @endif
            <label for="month">Untuk Berapa Bulan</label>
            <input type="number" name="month" id="month" min="1" value="1">
            <label for="method">Metode pembayaran</label>
            <select name="payment_method" id="method">
                <option value="cash">Cash</option>
                <option value="flip">Flip</option>
            </select>
            <button type="submit">Bayar</button>
        </form>
    </main>
</body>

</html>
