<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = ['search'];

    public function render()
    {
        $users = User::query()
            ->when($this->search, fn($q) =>
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%"))
            ->paginate(10);

        return view('livewire.admin.users', compact('users'));
    }
}
