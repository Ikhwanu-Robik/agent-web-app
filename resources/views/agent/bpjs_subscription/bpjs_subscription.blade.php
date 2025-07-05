<h1>Bayar BPJS</h1>

<h2>Cari tahu masa aktif BPJS mu</h2>

<form action="" method="POST">
    <label for="civil-id">NIK</label>
    <input type="number" name="civil_id" id="civil-id">
    <button type="submit">Cari data BPJS</button>
</form>

{{-- @if ($bpjs)
    <section id="bpjs-active-status">
        @if ($bpjs->stillSubscribed)
            Kamu sudah membayar BPJS sampai {{ 'Januari 2026' }}
        @else
            Kamu tidak memiliki langganan BPJS yang aktif
        @endif
    </section>
@endif --}}

<h2>atau langsung berlangganan</h2>

<form action="" method="post">
    @if (isset($bpjs))
        <input type="hidden" name="civil_information_id" value="{{ $civil_information->NIK }}">
    @else
        <label for="civil-id">NIK</label>
        <input type="number" name="civil_id" id="civil-id">
    @endif
    <label for="month">Untuk Berapa Bulan</label>
    <input type="number" name="month" id="month" min="1" value="1">
    <button type="submit">Bayar</button>
</form>
