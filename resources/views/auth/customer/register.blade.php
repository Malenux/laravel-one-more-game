<section class="customer-register">
    <div class="customer-register__header">
        <h1>Registrarse</h1>
        <h2>Cliente</h2>
    </div>
    <form method="POST" action="{{ route('customer-register') }}" class="customer-register__form">
        @csrf

        <div class="customer-register__form__body">

            <label for="name" class="customer-register__form__label">Nombre</label>
            <input type="text" class="customer-register__form__input" 
                id="name" name="name" 
                placeholder="Nombre" 
                autocomplete="name" 
                required
            >

            <label for="email" class="customer-register__form__label">Email</label>
            <input type="email" class="customer-register__form__input" 
                id="email" name="email" 
                placeholder="Email" 
                autocomplete="email" 
                required
            >

            <label for="password" class="customer-register__form__label">Contraseña</label>
            <input type="password" class="customer-register__form__input" 
                id="password" name="password" 
                placeholder="Contraseña" 
                autocomplete="new-password" 
                required
            >

            <label for="password_confirmation" class="customer-register__form__label">Confirmación de contraseña</label>
            <input type="password" class="customer-register__form__input" 
                id="password_confirmation" name="password_confirmation" 
                placeholder="Confirmación de contraseña" 
                autocomplete="confirm-password" 
                required
            >
        </div>

        <div class="customer-register__form__footer">
            <button type="button" class="customer-register__form__button--login">
                <a href="{{ route('customer-login') }}">Iniciar sesión</a>
            </button>

            <button type="submit" class="customer-register__form__button--register">Registrarse</button>
        </div>

    </form>
</div>
