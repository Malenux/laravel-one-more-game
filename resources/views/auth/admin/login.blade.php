<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Login' }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="auth auth--admin">

<main class="auth__container">

    <header class="auth__header">
        <h1 class="auth__title">Iniciar sesión</h1>
        <h2 class="auth__subtitle">Administrador</h2>
    </header>

    <section class="auth__card">

        <form method="POST" action="{{ route('login') }}" class="auth-form">
            @csrf

            <div class="auth-form__fields">

                <label for="email" class="auth-form__label">Email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    class="auth-form__input"
                    value="{{ old('email') }}"
                    placeholder="Email"
                    autocomplete="username"
                    required
                >

                <label for="password" class="auth-form__label">Contraseña</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    class="auth-form__input"
                    placeholder="Contraseña"
                    autocomplete="current-password"
                    required
                >

                <div class="auth-form__options">
                    <label class="auth-form__remember">
                        <input type="checkbox" name="remember">
                        Recordarme
                    </label>
                </div>

            </div>

            @if ($errors->any())
                <div class="auth-form__errors">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="auth-form__error">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="auth-form__actions">

                <a href="{{ route('password.request') }}"
                   class="auth-form__button auth-form__button--secondary">
                   ¿Olvidaste tu contraseña?
                </a>

                <button type="submit"
                        class="auth-form__button auth-form__button--primary">
                    Iniciar sesión
                </button>

            </div>

        </form>

    </section>

</main>

</body>
</html>