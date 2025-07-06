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
    <input type="number" name="civil_id" id="civil-id"
        value="{{ session('bpjs') ? session('bpjs')->civilInformation->NIK : '' }}">
    <button type="submit">Cari data BPJS</button>
</form>

@if (session('bpjs'))
    @php $bpjs = session("bpjs"); @endphp
    <section id="bpjs-active-status">
        @if ($bpjs->isStillActive())
            Kamu sudah membayar BPJS sampai {{ $bpjs->dueDate()->monthName . ' ' . $bpjs->dueDate()->year }}
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
