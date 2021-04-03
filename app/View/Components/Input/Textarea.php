<?php

namespace App\View\Components\Input;

use App\View\Components\Input;

class Textarea extends Input
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $langFile, $langKey = null, $s = 12, $m = null, $l = null, $xl = null)
    {
        parent::__construct($id, $langFile, $langKey, $s, $m, $l, $xl);
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
