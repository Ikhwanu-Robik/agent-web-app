<h1>You are an Admin, {{ Auth::user()->name }}</h1>
<p>You may change the data of this application. But be wary! Deleting data that has already been used for a transaction
    will mess the transaction history! Although we of course will try to prevent you from doing anything destructive.
</p>

@include("components.master.header")
