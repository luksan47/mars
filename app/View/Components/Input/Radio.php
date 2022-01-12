<?php

namespace App\View\Components\Input;

use App\View\Components\Input;
use Illuminate\View\Component;

class Radio extends Input
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.input.checkbox');
    }
}
