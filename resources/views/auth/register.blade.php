<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: sans-serif;
        }

        body {
            width: 100vw;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        main {
            background-color: rgb(37, 104, 175);
            width: 30%;
            height: 70%;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2em;
            gap: 1em;
        }

        main form {
            display: flex;
            flex-direction: column;
            gap: 0.5em;
            width: 50%;
        }

        main form input,
        button {
            padding: 0.3em;
        }

        main a {
            color: rgb(255, 255, 255);
        }

        main a:hover {
            color: lightblue;
        }
    </style>
</head>

<body>
    <main>
        <h1>Register</h1>

        @if ($errors->any())
            <div>
                @foreach ($errors->all() as $error)
                    {{ $error }} <br />
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route("register") }}" enctype="multipart/form-data">
            @csrf
            <input type="text" name="name" placeholder="name" value="{{ old('name') }}" />
            <input type="email" name="email" placeholder="email" value="{{ old('email') }}" />
            <input type="password" name="password" placeholder="password" />
            <label for="photo_profile">profile photo</label>
            <input type="file" name="profile_photo" id="photo_profile">
            <button type="submit">Register</button>
        </form>

        <span>Already have an account? </span><a href="{{ route("login.form") }}">Login</a>
    </main>
</body>

</html>
