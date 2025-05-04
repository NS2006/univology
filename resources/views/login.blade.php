<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Univology | Login</title>
</head>
<body>
    <h1>Login Page</h1>

    <form action="/login" method="POST">
        @csrf

        <label for="email">Email</label>
        <input type="text" id="email", name="email" required value="{{old('email')}}">
        <br>

        <label for="password">password</label>
        <input type="password" id="password" name="password" required>
        <br>

        <button type="submit">Login</button>

        @error('email')
        <p>Email must ends with either @uni.ac.id or @uni.edu</p>
        @enderror

        @if(session()->has('loginError'))
            <p>{{ session('loginError') }}</p>
        @endif
    </form>
</body>
</html>
