<x-layouts.public>
    <h1>{{ $faq->locale[app()->getLocale()]['question'] }}</h1>
    <p>{{ $faq->locale[app()->getLocale()]['answer'] }}</p>
</x-layouts.public>
