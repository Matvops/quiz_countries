<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class question extends Component
{

    public string $number;
    public $total;
    public $country;

    /**
     * Create a new component instance.
     */
    public function __construct(string $country, string $number, string $total)
    {
        $this->number = $number;
        $this->total = $total;
        $this->country = $country;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.question');
    }
}
