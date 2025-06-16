@if ($errors->any())
<div>
@foreach ($errors->all() as $error)
   {{ $error }} <br/>
@endforeach
</div>
@endif

@if (session("auth_fail"))
<div>
   {{ session("auth_fail") }}
</div>
@endif

<form method="POST" action="/login">
   @csrf
   <input type="email" name="email" placeholder="email"/>
   <input type="password" name="password" placeholder="password"/>
   <button type="submit">Login</button>
</form>

<span>Don't have an account? </span><a href="/register">Register</a>