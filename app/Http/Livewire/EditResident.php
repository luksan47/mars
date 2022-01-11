<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class EditResident extends Component
{
    public User $user;
    public bool $isResident;

    public function mount()
    {
        $this->isResident = $this->user->isResident();
    }

    public function switch(){
        if($this->isResident)
            $this->user->setExtern();
        else
            $this->user->setResident();
        $this->isResident = !$this->isResident;
    }

    public function render()
    {
        return view('secretariat.statuses.edit_resident_component');
    }
}
