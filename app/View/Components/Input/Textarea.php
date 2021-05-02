<?php

namespace App\View\Components\Input;

use App\View\Components\Input;

class Textarea extends Input
{
    public function __construct($id, $locale = null, $text = null, $s = 12, $m = null, $l = null, $xl = null, $onlyInput = false)
    {
        parent::__construct($id, $locale, $text, $s, $m, $l, $xl, $onlyInput);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.input.textarea');
    }
}
