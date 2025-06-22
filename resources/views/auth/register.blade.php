@if ($errors->any())
<div>
@foreach ($errors->all() as $error)
   {{ $error }} <br/>
@endforeach
</div>
@endif

<form method="POST" action="/register">
   @csrf
   <input type="text" name="name" placeholder="name"/>
   <input type="email" name="email" placeholder="email"/>
   <input type="password" name="password" placeholder="password"/>
   <button type="submit">Register</button>
</form>

<span>Already have an account? </span><a href="/login">Login</a>