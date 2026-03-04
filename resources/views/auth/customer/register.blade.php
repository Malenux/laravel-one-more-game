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
<body>
    <main class="customer-register">

        <section class="register-header">
            <h1>Registrarse</h1>
            <h2>Cliente</h2>
        </section>

        <section class="register-body">
            <form method="POST" action="{{ route('customer.register') }}" class="register-form">
                @csrf

                <div class="register-form__body">

                    <label for="name" class="register-form__label">Nombre</label>
                    <input type="text" class="register-form__input" 
                        id="name" name="name" 
                        placeholder="Nombre" 
                        autocomplete="name" 
                        required
                    >

                    <label for="email" class="register-form__label">Email</label>
                    <input type="email" class="register-form__input" 
                        id="email" name="email" 
                        placeholder="Email" 
                        autocomplete="email" 
                        required
                    >

                    <label for="password" class="register-form__label">Contraseña</label>
                    <input type="password" class="register-form__input" 
                        id="password" name="password" 
                        placeholder="Contraseña" 
                        autocomplete="new-password" 
                        required
                    >

                    <label for="password_confirmation" class="register-form__label">Confirmación de contraseña</label>
                    <input type="password" class="register-form__input" 
                        id="password_confirmation" name="password_confirmation" 
                        placeholder="Confirmación de contraseña" 
                        autocomplete="confirm-password" 
                        required
                    >
                </div>

                <div class="register-form__error-list">
                    <ul></ul>
                </div>

                <div class="register-form__footer">
                    <button type="button" class="register-form__button--login">
                        <a href="{{ route('customer.login') }}">Iniciar sesión</a>
                    </button>

                    <button type="submit" 
                        class="register-form__button--register"
                        data-endpoint="{{ route('customer.register') }}">
                        Registrarse
                    </button>    
                </div>

            </form>
        </section>
        
    </main>
</body>
</html>
