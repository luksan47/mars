<?php

namespace App\View\Components\Input;

use Illuminate\View\Component;

class Checkbox extends Component
{
    public $text;

    /**
     * Create a new button instance.
     * The button's type is submit by default,.
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
        return view('components.input.checkbox');
    }
}
