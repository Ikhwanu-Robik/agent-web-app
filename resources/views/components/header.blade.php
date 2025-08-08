<header>
    <div>
        <img src="{{ config('app.url') . '/storage/' . Auth::user()->profile_photo }}" alt="profile_photo"
            id="profile_photo">
        <span id="username">{{ Auth::user()->name }}</span>
        <a href="{{ route("home") }}" class="nav-button">Dashboard</a>
        <a href="{{ route("vouchers") }}" class="nav-button">Vouchers</a>
        <a href="{{ route("report") }}" class="nav-button">Transaction History</a>
    </div>
    <form action="{{ route("logout") }}" method="post">
        @csrf
        <button type="submit" id="logout-button">Logout</button>
    </form>
</header>
