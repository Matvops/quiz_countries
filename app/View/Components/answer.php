<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class answer extends Component
{

    public $answer;
    
    /**
     * Create a new component instance.
     */
    public function __construct(string $answer)
    {
        $this->answer = $answer;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.answer');
    }
}
