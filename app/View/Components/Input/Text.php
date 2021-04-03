<?php

namespace App\View\Components\Input;

use App\View\Components\Input;

class Text extends Input
{
    public $helper;
    /**
     * Create a new text input instance.
     * @param string $helper helper message
     * @return void
     */
    public function __construct($id, $locale = null, $text = null, $s = 12, $m = null, $l = null, $xl = null, $onlyInput = false, $helper = null)
    {
        parent::__construct($id, $locale, $text, $s, $m, $l, $xl, $onlyInput);
        $this->helper = $helper;
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
