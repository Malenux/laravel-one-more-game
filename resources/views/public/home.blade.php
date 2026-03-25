<x-layouts.public>
    <div class="grid">
        <x-grid :elements="$games" route="game"/>
    </div>

    <x-front.faqs name="HOME" />
</x-layouts.public>