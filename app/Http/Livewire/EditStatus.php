<?php

namespace App\Http\Livewire;

use App\Models\Semester;
use App\Models\User;
use Livewire\Component;

class EditStatus extends Component
{
    public User $user;
    public Semester $semester;
    public string $status; //current status to display

    public function mount()
    {
        $this->status = $this->user->getStatus();
    }

    public function set($status){
        $this->user->setStatusFor($this->semester, $status);
        $this->status = $status;
    }

    public function render()
    {
        return view('secretariat.statuses.edit_status_component');
    }
}
