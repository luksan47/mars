<?php

namespace App\View\Components;

use Illuminate\View\Component;
use InvalidArgumentException;

abstract class Input extends Component
{
    public $id;
    public $label;
    public $s;
    public $m;
    public $l;
    public $xl;
    public $value;
    public $onlyInput;

    /**
     * Create a new input instance.
     * The parameter names are written in kebab-case (only_input) in blades.
     * PHP Variables should be written with a ':' prefix
     * eg. :message="$message"
     * See https://laravel.com/docs/8.x/blade#components for more details.
     * @param string $id input id and default name
     * @param string $locale if text is not provided, the label will be @lang($locale.$id)
     * @param string $text if provided, the label will be @lang($text)
     * @param int $s size for small displays (default: 12)
     * @param int $m size for medium displays  (default: s)
     * @param int $l size for large displays (default: s)
     * @param int $xl size for xl displays (default: s)
     * @param bool $onlyInput if provided, the content will not be wrapped in an input-field
     * @param $attributes any other attribute given will be added to the input tag
     * @return void
     */
    public function __construct($id = null, $locale = null, $text = null, $s = 12, $m = null, $l = null, $xl = null, $onlyInput = false)
    {
        if (($id == null || $locale == null) && $text == null) {
            throw new InvalidArgumentException('At least one of ($id + $locale) or $text must be given. id: '.$id.', locale: '.$locale.' text: '.$text);
        }
        $this->id = $id;
        $this->label = __($text ?? ($locale.'.'.$id));
        $this->s = $s;
        $this->m = $m;
        $this->l = $l;
        $this->xl = $xl;
        $this->onlyInput = $onlyInput;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    abstract public function render();
}
