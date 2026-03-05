<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Customer Login' }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>
<body class="customer-auth">
    <main class="customer-login">

        <section class="customer-auth-header">
            <h1>Iniciar sesión</h1>
            <h2>Cliente</h2>
        </section>

        <section class="customer-auth-body">
            <form method="POST" action="{{ route('customer.login') }}" class="customer-auth-form">
                @csrf

                <div class="customer-auth-form__body">

                    <label for="email" class="customer-auth-form__label">Email</label>
                    <input type="email" class="customer-auth-form__input"
                        id="email" name="email"
                        value="{{ old('email') }}"
                        placeholder="Email"
                        autocomplete="username"
                        autofocus
                        required
                    >

                    <label for="password" class="customer-auth-form__label">Contraseña</label>
                    <input type="password" class="customer-auth-form__input"
                        id="password" name="password"
                        placeholder="Contraseña"
                        autocomplete="current-password"
                        required
                    >

                    <div class="customer-auth-form__options">
                        <label class="customer-auth-form__remember">
                            <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            Recordarme
                        </label>
                    </div>

                </div>
                
                @if ($errors->any())
                    <div class="customer-auth-form__error-list">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="customer-auth-form__footer">
                    <button type="button" class="customer-auth-form__button--secondary">
                        <a href="{{ route('customer.password.request') }}">¿Olvidaste tu contraseña?</a>
                    </button>

                    <button type="submit"
                        class="customer-auth-form__button--primary"
                        data-endpoint="{{ route('customer.login') }}">
                        Iniciar sesión
                    </button>
                </div>

            </form>
        </section>

    </main>
</body>
</html>