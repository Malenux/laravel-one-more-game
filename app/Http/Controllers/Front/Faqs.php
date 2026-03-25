<?php

namespace App\View\Components\Front;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use App\Models\MongoDB\Faq;
use Illuminate\Http\Request;

class Faqs extends Component
{
    public $faqs;

    public function __construct(public ?string $name = null, private Request $request)
    {
        try {
            $this->faqs = Faq::query()
                ->when($this->name, fn($q) => $q->where('name', $this->name))
                ->where('active', true)
                ->get();
        } catch (\Exception $e) {
            $this->faqs = collect();
        }
    }

    public function render(): View
    {
        return view('components.front.faqs');
    }
}