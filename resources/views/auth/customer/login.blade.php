<body class="auth auth--customer">

<main class="auth__container">

    <header class="auth__header">
        <h1 class="auth__title">Iniciar sesión</h1>
        <h2 class="auth__subtitle">Cliente</h2>
    </header>

    <section class="auth__card">

        <form method="POST" action="{{ route('customer.login') }}" class="auth-form">
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

                <a href="{{ route('customer.password.request') }}"
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