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
<body class="auth">
    <main class="login">

        <section class="auth-header">
            <h1>Iniciar sesión</h1>
            <h2>Administrador</h2>
        </section>

        <section class="auth-body">
            <form method="POST" action="{{ route('login') }}" class="auth-form">
                @csrf

                <div class="auth-form__body">

                    <label for="email" class="auth-form__label">Email</label>
                    <input type="email" class="auth-form__input"
                        id="email" name="email"
                        value="{{ old('email') }}"
                        placeholder="Email"
                        autocomplete="username"
                        autofocus
                        required
                    >

                    <label for="password" class="auth-form__label">Contraseña</label>
                    <input type="password" class="auth-form__input"
                        id="password" name="password"
                        placeholder="Contraseña"
                        autocomplete="current-password"
                        required
                    >

                    <div class="auth-form__options">
                        <label class="auth-form__remember">
                            <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            Recordarme
                        </label>
                    </div>

                </div>
                
                @if ($errors->any())
                    <div class="auth-form__error-list">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="auth-form__footer">
                    <button type="button" class="auth-form__button--secondary">
                        <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                    </button>

                    <button type="submit"
                        class="auth-form__button--primary"
                        data-endpoint="{{ route('login') }}">
                        Iniciar sesión
                    </button>
                </div>

            </form>
        </section>

    </main>
</body>
</html>