<?php

namespace App\View\Components\Daftar;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Closure;

class Daftar extends Component
{
    public string $route;
    public bool $showSelf;

    /**
     * Create a new component instance.
     */
    public function __construct($route = 'daftar', $showSelf = false)
    {
        $this->route    = $route;
        $this->showSelf = $showSelf;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.daftar.daftar');
    }
}
