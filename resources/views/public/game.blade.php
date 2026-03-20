<x-layouts.public :title="'Juego'">
    <h1>{{ $game->locale[app()->getLocale()]['title'] }}</h1>
    <p>{{ $game->locale[app()->getLocale()]['description'] }}</p>
</x-layouts.public>
