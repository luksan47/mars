<?php

namespace App\View\Components;

use Illuminate\View\Component;

abstract class Input extends Component
{
    public $id;
    public $lang;
    public $s, $m, $l, $xl;
    public $value;

    /**
     * Create a new input instance.
     * The parameter names are written in kebab-case in blades.
     * eg. lang_file="auth"
     * PHP Variables should be written with a : prefix
     * eg. :message="$message"
     * See https://laravel.com/docs/8.x/blade#components for more details.
     * @param $id input id and name
     * @param $langFile the label will be @lang($langFile.$id)
     * @param $langKey if provided, the label will be @lang($langFile.$langKey)
     * @param $s size for small displays (default: 12)
     * @param $m size for medium displays  (default: 12)
     * @param $l size for large displays (default: 12)
     * @param $xl size for xl displays (default: 12)
     * @param $attributes any other attribute given will be added to the input tag
     * @return void
     */
    public function __construct($id, $langFile, $langKey, $s, $m, $l, $xl)
    {
        $this->id = $id;
        $this->lang = $langFile . '.' . ($langKey ?? $id);
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
    abstract public function render();
}
