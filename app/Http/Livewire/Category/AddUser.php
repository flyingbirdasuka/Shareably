<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use App\Models\User;
use LivewireUI\Modal\ModalComponent;

class AddUser extends ModalComponent
{
    public $email;
    public $user_id;
    public $category_id;
    public $users =[];

    protected $rules = [
        'email' => 'required|email',
    ];

    protected $message = [
        'email.required' => 'The email cannot be empty.',
        'email.email' => 'The email Address format is not valid.'
    ];

    public function mount($category_id, $users)
    {
        $this->category_id = $category_id;
        $this->users = $users;
    }

    public function add()
    {
        $this->validate();

        $user = User::where('email',$this->email)->first();
        if(!$user){
            session()->flash('message', 'This email does not exists as a user.');
            return;
        } else {
            $user_id = $user->id;
        }
        foreach($this->users as $users){
            if ($users['id'] == $user->id) {
                session()->flash('message', 'This email already exists in this category.');
                return;
            }
        }

        User::findOrFail($user_id)->categories()->attach($this->category_id);
        session()->flash('message', 'User successfully added.');
        return redirect('categories/'.$this->category_id);
    }

    public function render()
    {
        return view('livewire.category.add-user');
    }
}