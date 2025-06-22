<h1>AgentLycoris : {{ Auth::user()->name }}</h1>
<form action="/logout" method="post">
    @csrf
    <button type="submit">Logout</button>
</form>

<h2>What To Do?</h2>

<a href="/master"><button>Switch to Admin</button></a>

<h3>or Proceed As Agent</h3>
<ul>
    <li><a href="/bus/ticket">Tiket Bus</a></li>
    <li><a href="/bpjs">Bayar BPJS</a></li>
    <li><a href="/film">Tiket Film</a></li>
    <li><a href="/game/topup">Top up Game</a></li>
    <li><a href="/power">Isi token listrik</a></li>
</ul>