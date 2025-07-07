<h1>You are an Admin, {{ Auth::user()->name }}</h1>
<p>You may change the data of this application. But be wary! Deleting data that has already been used for a transaction
    will mess the transaction history! Although we of course will try to prevent you from doing anything destructive.
</p>

<ul>
    <li><a href="/master/vouchers">Master Vouchers</a></li>
    <li><a href="/master/bus">Master Bus</a></li>
    <li><a href="/master/bus/station">Master Bus Station</a></li>
    <li><a href="/master/bus/schedules">Master Bus Schedule</a></li>
    <li><a href="/master/bpjs/prices">Master BPJS</a></li>
</ul>
