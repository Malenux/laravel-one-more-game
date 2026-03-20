@foreach ($elements as $element)
    <a href="{{ route(app()->getLocale() . '.' . $route, $element->locale[app()->getLocale()]['title']) }}" class="element-card">
        <div class="element-card__image">
            <img src="https://fastly.picsum.photos/id/274/230/125.jpg?hmac=fMh8SuhRWv88RJOwwKecuJcw44CU0p53RtKVInGDDms" alt="{{ $element->locale[app()->getLocale()]['title'] }}" />
        </div>
        <div class="element-card__title">{{ $element->locale[app()->getLocale()]['title'] }}</div>
    </a>
@endforeach