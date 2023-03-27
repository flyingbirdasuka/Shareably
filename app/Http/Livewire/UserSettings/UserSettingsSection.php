<?php

namespace App\Http\Livewire\UserSettings;

use DB;
use Livewire\Component;
use App\Models\UserSettings;
use App\Models\Language;


class UserSettingsSection extends Component
{
    public $user;
    public $user_settings;
    public $email_subscription;

    public function mount()
    {
        $this->user = auth()->user();
        $this->user_settings = UserSettings::where('user_id', $this->user->id)->first();
        $this->fill([
            'email_subscription' => $this->user_settings->email_subscription,
        ]);
    }

    public function render()
    {
        return view('livewire.user-settings.user-settings-sectiont', [
            'user', $this->user, 
            'email_subscription', $this->email_subscription
        ]);
    }

    public function submit()
    {
        // update the user settings table
        $user = UserSettings::where('user_id', $this->user->id)->update([ 
            'email_subscription' => $this->email_subscription
        ]); 
    }

    public function email_unsubscribe($user_id)
    {
        $user = UserSettings::where('user_id', $user_id)->update([
            'email_subscription' => 0
        ]); 
        return redirect()->route('profile.show', $user);
    }
}
