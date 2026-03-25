@props(['name' => null])

@php
    $faqs = \App\Models\MongoDB\Faq::query()
        ->when($name, fn($q) => $q->where('name', $name))
        ->get()
        ->filter(fn($faq) => $faq->active === true);
@endphp

<section class="faqs">
    @foreach($faqs as $faq)
        <div class="faq">
            <div class="faq__question">
                <span>{{ $faq->locale[app()->getLocale()]['question'] ?? '' }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M7 10l5 5 5-5z"/>
                </svg>
            </div>
            <div class="faq__answer">
                <p>{{ $faq->locale[app()->getLocale()]['answer'] ?? '' }}</p>
            </div>
        </div>
    @endforeach
</section>