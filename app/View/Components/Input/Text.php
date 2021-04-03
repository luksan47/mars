<?php

namespace App\View\Components\Input;

use App\View\Components\Input;

class Text extends Input
{
    public $onlyInput, $message;
    /**
     * Create a new text input instance.
     * @param $onlyInput if provided, the content will not be wrapped in an input-field
     * @param $message helper message
     * @return void
     */
    public function __construct($id, $langFile, $s = 12, $m = null, $l = null, $xl = null, $onlyInput = false, $message = null)
    {
        parent::__construct($id, $langFile, $s, $m, $l, $xl);
        $this->onlyInput = $onlyInput;
        $this->message = $message;
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
