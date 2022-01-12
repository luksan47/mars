<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ParentChildForm extends Component
{
    public $items;
    public $name;
    public $title;
    public $helper;
    public $hidden;

    public function mount($items = [''])
    {
        if (count($items) == 0) {
            $items = [''];
        }
        $this->items = $items;
        $this->hidden = count($items) == 1;
    }

    public function show()
    {
        $this->hidden = ! $this->hidden;
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
