<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Customer Register' }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="auth auth--customer">

<main class="auth__container">

    <section class="auth__header">
        <h1 class="auth__title">Registrarse</h1>
        <h2 class="auth__subtitle">Cliente</h2>
    </section>

    <section class="auth__card">

        <form method="POST" action="{{ route('customer.register') }}" class="auth-form">
            @csrf

            <div class="auth-form__fields">

                <label for="name" class="auth-form__label">Nombre</label>
                <input type="text"
                       class="auth-form__input"
                       id="name"
                       name="name"
                       placeholder="Nombre"
                       autocomplete="name"
                       required>

                <label for="email" class="auth-form__label">Email</label>
                <input type="email"
                       class="auth-form__input"
                       id="email"
                       name="email"
                       placeholder="Email"
                       autocomplete="email"
                       required>

                <label for="password" class="auth-form__label">Contraseña</label>
                <input type="password"
                       class="auth-form__input"
                       id="password"
                       name="password"
                       placeholder="Contraseña"
                       autocomplete="new-password"
                       required>

                <label for="password_confirmation" class="auth-form__label">
                    Confirmación de contraseña
                </label>
                <input type="password"
                       class="auth-form__input"
                       id="password_confirmation"
                       name="password_confirmation"
                       placeholder="Confirmación de contraseña"
                       autocomplete="new-password"
                       required>

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

                <a href="{{ route('customer.login') }}"
                   class="auth-form__button auth-form__button--secondary">
                    Iniciar sesión
                </a>

                <button type="submit"
                        class="auth-form__button auth-form__button--primary"
                        data-endpoint="{{ route('customer.register') }}">
                    Registrarse
                </button>

            </div>

        </form>

    </section>

</main>

</body>
</html>