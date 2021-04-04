<?php

namespace App\View\Components\Input;

use App\View\Components\Input;

class Select extends Input
{
    public $elements;
    public $withoutPlaceholder;
    public $withoutLabel;
    public $default;

    /**
     * Create a new select component instance with a search field.
     * @param $elements elements that can be selected. Id and name tags will be used if exists, otherwise the value itself.
     * @param $withoutPlaceholder (the default placeholder is general.choose, that can be overwritten with a placeholder attribute)
     * @param $withoutLabel
     * @param $default the default value (the id will be matched)
     * @return void
     */
    public function __construct($id, $elements, $withoutPlaceholder = false, $withoutLabel = false, $default = null, $locale = null, $text = null, $s = 12, $m = null, $l = null, $xl = null, $onlyInput = false)
    {
        parent::__construct($id, $locale, $text, $s, $m, $l, $xl, $onlyInput);
        $this->elements = (isset($elements[0]->name) ? $elements->sortBy('name') : $elements);
        $this->withoutPlaceholder = $withoutPlaceholder;
        $this->withoutLabel = $withoutLabel;
        $this->default = $default;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.input.select');
    }
}
