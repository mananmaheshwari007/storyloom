<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Log In — {{ setting('site_name', 'Storyloom') }}</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Libre+Caslon+Text:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Edu+SA+Hand:wght@400..700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --parchment: #F8F4EC;
            --paper: #FFFDF8;
            --ink: #1D2A44;
            --ink-soft: rgba(29, 42, 68, 0.74);
            --terra: #B55B29;
            --terra-deep: #96471D;
            --grove: #3F4E3A;
            --font-display: "Cormorant Garamond", Georgia, serif;
            --font-body: "Libre Caslon Text", Georgia, serif;
            --font-hand: "Edu SA Hand", cursive;
        }

        body {
            font-family: var(--font-body);
            background-color: var(--parchment);
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='180' height='180'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='2' stitchTiles='stitch'/%3E%3CfeColorMatrix type='saturate' values='0'/%3E%3CfeComponentTransfer%3E%3CfeFuncA type='linear' slope='0.06'/%3E%3C/feComponentTransfer%3E%3C/filter%3E%3Crect width='180' height='180' filter='url(%23n)'/%3E%3C/svg%3E");
            color: var(--ink);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            margin: 0;
        }

        .login-card {
            background-color: var(--paper);
            border: 1px solid rgba(29, 42, 68, 0.12);
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(29, 42, 68, 0.06);
            width: 100%;
            max-width: 440px;
            padding: 40px;
            box-sizing: border-box;
            text-align: center;
        }

        .logo-wrap {
            margin-bottom: 28px;
        }

        .logo-wrap img.emblem {
            margin: 0 auto 12px;
            display: block;
        }

        .logo-wrap h1 {
            font-family: var(--font-display);
            font-size: 2.2rem;
            font-weight: 600;
            margin: 0 0 6px 0;
            line-height: 1.1;
        }

        .logo-wrap h1 em {
            color: var(--terra);
            font-style: italic;
            font-weight: 500;
        }

        .logo-wrap p.tagline {
            font-size: 0.95rem;
            color: var(--ink-soft);
            margin: 0;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 0.88rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--ink-soft);
            margin-bottom: 6px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            font-family: var(--font-body);
            font-size: 0.95rem;
            border: 1px solid rgba(29, 42, 68, 0.2);
            border-radius: 6px;
            background-color: #fff;
            color: var(--ink);
            box-sizing: border-box;
            transition: border-color 0.2s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--terra);
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
            text-align: left;
        }

        .checkbox-group input {
            accent-color: var(--terra);
            width: 16px;
            height: 16px;
        }

        .checkbox-group label {
            font-size: 0.9rem;
            color: var(--ink-soft);
            cursor: pointer;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background-color: var(--ink);
            color: #fff;
            font-family: var(--font-display);
            font-weight: 600;
            font-size: 1.1rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit:hover {
            background-color: var(--terra);
        }

        .error-list {
            background-color: rgba(181, 91, 41, 0.08);
            border: 1px solid rgba(181, 91, 41, 0.3);
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 20px;
            text-align: left;
            font-size: 0.9rem;
            color: var(--terra-deep);
        }

        .error-list ul {
            margin: 0;
            padding-left: 20px;
        }

        .back-link {
            display: inline-block;
            margin-top: 24px;
            font-size: 0.9rem;
            color: var(--ink-soft);
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .back-link:hover {
            color: var(--terra);
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="logo-wrap">
            <img class="emblem" src="{{ asset(setting('site_emblem', 'assets/img/logo-emblem.png')) }}" alt="" width="46" height="45">
            <h1>Story<em>loom</em></h1>
            <p class="tagline">Administration Console</p>
        </div>

        @if ($errors->any())
            <div class="error-list">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>
                <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password">
            </div>

            <div class="checkbox-group">
                <input id="remember_me" type="checkbox" name="remember">
                <label for="remember_me">Remember me</label>
            </div>

            <button type="submit" class="btn-submit">
                <span>Sign In</span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 18px; height: 18px;"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </button>
        </form>

        <a href="{{ url('/') }}" class="back-link">Back to website</a>
    </div>

</body>
</html>
