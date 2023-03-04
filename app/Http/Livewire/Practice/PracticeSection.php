<?php

namespace App\Http\Livewire\Practice;

use Livewire\Component;
use App\Models\Practice;
use App\Models\User;

class PracticeSection extends Component
{
    public $practices;
    public $user;

    protected $listeners = [
        'refreshParent' => '$refresh',
    ];

    public function mount()
    {
        $user = auth()->user();
        $this->practices = $user->is_admin ? Practice::all() : User::find($user)->first()->practices()->get();
    }

    public function render()
    {
        return view('livewire.practice.practice-section');
    }
}
