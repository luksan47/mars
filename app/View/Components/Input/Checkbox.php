<?php

namespace App\View\Components\Input;

use Illuminate\View\Component;

class Checkbox extends Component
{
    public $text;
    /**
     * Create a new button instance.
     * The button's type is submit by default,
     * @return void
     */
    public function __construct($text)
    {
        $this->text = $text;
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
