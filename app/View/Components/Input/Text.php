<?php

namespace App\View\Components\Input;

use App\View\Components\Input;

class Text extends Input
{
    /**
     * Create a new text input instance.
     * @return void
     */
    public function __construct($id, $langFile, $s = 12, $m = 12, $l = 12, $xl = 12)
    {
        parent::__construct($id, $langFile, $s, $m, $l, $xl);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.input.text');
    }
}
