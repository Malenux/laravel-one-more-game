<section class="admin-form">

  <div class="form__header">
    <div class="form__header-box">

      <x-tabs :tabs="['general' => 'General', 'avatar' => 'Avatar']" />

      <div class="form__header-buttons">
        <button class="clean-button" data-endpoint="{{ route('users_create') }}">
          <span class="tooltip">Limpiar</span>
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M16.24,3.56L21.19,8.5C21.97,9.29 21.97,10.55 21.19,11.34L12,20.53C10.44,22.09 7.91,22.09 6.34,20.53L2.81,17C2.03,16.21 2.03,14.95 2.81,14.16L13.41,3.56C14.2,2.78 15.46,2.78 16.24,3.56M4.22,15.58L7.76,19.11C8.54,19.9 9.8,19.9 10.59,19.11L14.12,15.58L9.17,10.63L4.22,15.58Z" />
          </svg>
        </button>
        <button class="save-button" data-endpoint="{{ route('users_store') }}">
          <span class="tooltip">Guardar</span>
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M15,9H5V5H15M12,19A3,3 0 0,1 9,16A3,3 0 0,1 12,13A3,3 0 0,1 15,16A3,3 0 0,1 12,19M17,3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V7L17,3Z" />
          </svg>
        </button>
      </div>

    </div>
  </div>

  <div class="form__body">
    <form>
      <input type="hidden" name="id" value="{{ $record->id ?? $record->_id }}">

      <x-tab id="general" active>
        <div class="form-element">
          <div class="form-title"><span>Nombre</span></div>
          <div class="form-element-input">
            <input type="text" name="name" value="{{ $record->name }}">
          </div>
        </div>
        <div class="form-element">
          <div class="form-title"><span>Email</span></div>
          <div class="form-element-input">
            <input type="email" name="email" value="{{ $record->email }}">
          </div>
        </div>
        <div class="form-element">
          <div class="form-title"><span>Contraseña</span></div>
          <div class="form-element-input">
            <input type="password" name="password">
          </div>
        </div>
        <div class="form-element">
          <div class="form-title"><span>Confirmación de contraseña</span></div>
          <div class="form-element-input">
            <input type="password" name="password_confirmation">
          </div>
        </div>
      </x-tab>

      <x-tab id="avatar">
        <div class="form-element">
          <div class="form-title"><span>Avatar</span></div>
          <div class="form-element-input">
            <x-upload-image name="avatar" :value="$record->avatar" quantity="single" configuration='{
              "thumbnail": {
                  "widthPx": "100",
                  "heightPx": "100"
              },
              "xs": {
                  "widthPx": "200",
                  "heightPx": "200"
              },
              "sm": {
                  "widthPx": "200",
                  "heightPx": "200"
              },
              "md": {
                  "widthPx": "450",
                  "heightPx": "450"
              },
              "lg": {
                  "widthPx": "450",
                  "heightPx": "450"
              }
            }' />
          </div>
        </div>
      </x-tab>

    </form>
    <div class="validation-errors"><ul></ul></div>
  </div>

</section>