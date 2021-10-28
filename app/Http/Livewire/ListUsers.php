<?php

namespace App\Http\Livewire;

use App\Models\Semester;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class ListUsers extends Component
{
    public $roles = [];
    public $workshops = [];
    public $statuses = [];

    public $filter_name = '';

    public function getUsersProperty()
    {
        $query = User::with(['roles', 'workshops', 'educationalInformation', 'allSemesters']);

        foreach ($this->roles as $role) {
            $query->whereHas('roles', function (Builder $query) use ($role) {
                $query->where('id', $role);
            });
        }

        foreach ($this->workshops as $workshop) {
            $query->whereHas('workshops', function (Builder $query) use ($workshop) {
                $query->where('id', $workshop);
            });
        }

        foreach ($this->statuses as $status) {
            $query->whereHas('allSemesters', function (Builder $query) use ($status) {
                $query->where('status', $status);
                $query->where('id', Semester::current()->id);
            });
        }
        if (isset($this->filter_name)) {
            $query->where('name', 'like', '%'.$this->filter_name.'%');
        }

        return $query->orderBy('name')->get();
    }

    public function deleteRole($role_id)
    {
        $this->roles = \array_diff($this->roles, [$role_id]);
    }

    public function addStatus($status_id)
    {
        $this->statuses[] = $status_id;
    }

    public function deleteStatus($status_id)
    {
        $this->statuses = \array_diff($this->statuses, [$status_id]);
    }

    public function addWorkshop($workshop_id)
    {
        $this->workshops[] = $workshop_id;
    }

    public function deleteWorkshop($workshop_id)
    {
        $this->workshops = \array_diff($this->workshops, [$workshop_id]);
    }

    public function render()
    {
        return view('secretariat.user.list_users_component');
    }
}
