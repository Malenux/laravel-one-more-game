<x-layouts.public :title="__('error.title')">
    <div class="error">
        <h1>{{ __('error.title') }}</h1>
        <p>{{ __('error.message') }}</p>
        <a href="{{ route(app()->getLocale() . '.home') }}" class="error__button">
            {{ __('error.button') }}
        </a>
    </div>
</x-layouts.public>