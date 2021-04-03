<?php

namespace App\View\Components\Input;

use App\View\Components\Input;

class Button extends Input
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.input.button');
    }
}
