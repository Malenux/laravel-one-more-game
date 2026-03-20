<x-layouts.public :title="'Juegos'">
    <div class="grid">
        <x-grid :elements="$games" route="game"/>
    </div>
</x-layouts.public>