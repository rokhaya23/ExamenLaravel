
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=\, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style1.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>login</title>
</head>
<body>
<div class="wrapper">
    <span class="bg-animate"></span>
    <span class="bg-animate2"></span>
    <div class="form-box login">
        <h2>Login</h2>
        <form method="post" action="{{route('users.login')}}">
            @csrf
            <div class="input-box">
                <input type="text" name="email" required>
                <label>Email</label>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" required>
                <label>Password</label>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <button type="submit" class="btn">Login</button>
{{--            <div class="logreg-link">--}}
{{--                <p>Don't have an account? <a href="#" class="register-link">--}}
{{--                        Sign Up--}}
{{--                    </a></p>--}}
{{--            </div>--}}

        </form>
    </div>
    <div class="info-text login">
        <h2>Welcome Back!</h2>
        <p></p>
    </div>

</div>

</body>
</html>
