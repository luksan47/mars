<?php

namespace App\View\Components\Input;

use App\View\Components\Input;

class Button extends Input
{
    public $text;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($text, $s = 12, $m = null, $l = null, $xl = null, $onlyInput = false)
    {
        $this->text = $text;
        $this->onlyInput = $onlyInput;
        $this->s = $s;
        $this->m = $m;
        $this->l = $l;
        $this->xl = $xl;
    }

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
