@foreach ($elements as $element)
    <a href="{{ route($route, $element->sitemap->slug) }}" class="element-card">
        <div class="element-card">
            <img src="https://image.tmdb.org/t/p/original/iLMtX4MGl8WjKCPfMgCdDuceOth.jpg" alt="{{ $element->title }}" class="element-card__img" />
        </div>
        <div class="element-card__title">{{ $element->title }}</div>
    </a>
@endforeach