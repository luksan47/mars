<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ParentChildForm extends Component
{
    public $items;
    public $name;
    public $title;
    public $helper;
    public $hidden; //if $optional is true, the form is hidden by default
    public $optional;

    public function mount($items = [''], $optional = false)
    {
        if(count($items ?? []) == 0) {
            $items = [''];
        }
        $this->items = $items;
        $this->hidden = $optional ? count($items) == 1 && $items[0] == '' : false;
        $this->optional = $optional;
    }

    public function show()
    {
        $this->hidden = !$this->hidden;
    }

    public function addItem()
    {
        $this->items[] = '';
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
    }

    public function render()
    {
        return view('livewire.parent-child-form');
    }
}
