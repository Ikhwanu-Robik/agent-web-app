@if ($errors->any())
<div>
@foreach ($errors->all() as $error)
   {{ $error }} <br/>
@endforeach
</div>
@endif

<form method="POST" action="/register" enctype="multipart/form-data">
   @csrf
   <input type="text" name="name" placeholder="name" value="{{ old("name") }}"/>
   <label for="photo_profile">profile_photo</label>
   <input type="file" name="profile_photo" id="photo_profile">
   <input type="email" name="email" placeholder="email" value="{{ old("email") }}"/>
   <input type="password" name="password" placeholder="password"/>
   <button type="submit">Register</button>
</form>

<span>Already have an account? </span><a href="/login">Login</a>