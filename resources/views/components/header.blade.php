@props(['title'])

@php
    $languages = \App\Models\MySQL\Language::where('active', true)->pluck('label', 'label')->toArray();
    $currentLocale = app()->getLocale();
@endphp

<header>
    <h1>{{ $title }}</h1>
    <x-language-selector :languages="$languages" />
</header>