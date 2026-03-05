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
<body class="customer-auth">
    <main class="customer-register">

        <section class="customer-auth-header">
            <h1>Registrarse</h1>
            <h2>Cliente</h2>
        </section>

        <section class="customer-auth-body">
            <form method="POST" action="{{ route('customer.register') }}" class="customer-auth-form">
                @csrf

                <div class="customer-auth-form__body">

                    <label for="name" class="customer-auth-form__label">Nombre</label>
                    <input type="text" class="customer-auth-form__input"
                        id="name" name="name"
                        placeholder="Nombre"
                        autocomplete="name"
                        required
                    >

                    <label for="email" class="customer-auth-form__label">Email</label>
                    <input type="email" class="customer-auth-form__input"
                        id="email" name="email"
                        placeholder="Email"
                        autocomplete="email"
                        required
                    >

                    <label for="password" class="customer-auth-form__label">Contraseña</label>
                    <input type="password" class="customer-auth-form__input"
                        id="password" name="password"
                        placeholder="Contraseña"
                        autocomplete="new-password"
                        required
                    >

                    <label for="password_confirmation" class="customer-auth-form__label">Confirmación de contraseña</label>
                    <input type="password" class="customer-auth-form__input"
                        id="password_confirmation" name="password_confirmation"
                        placeholder="Confirmación de contraseña"
                        autocomplete="new-password"
                        required
                    >

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
                        <a href="{{ route('customer.login') }}">Iniciar sesión</a>
                    </button>

                    <button type="submit"
                        class="customer-auth-form__button--primary"
                        data-endpoint="{{ route('customer.register') }}">
                        Registrarse
                    </button>
                </div>

            </form>
        </section>

    </main>
</body>
</html>