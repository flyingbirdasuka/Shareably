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
    public $notification_setting;
    public $sound_setting;

    public function mount()
    {
        $this->user = auth()->user();
        $this->user_settings = UserSettings::where('user_id', $this->user->id)->first();
        $this->fill([
            'notification_setting' => $this->user_settings->notification_setting, 
            'sound_setting' => $this->user_settings->sound_setting, 
        ]);
    }

    public function render()
    {
        return view('livewire.user-settings.user-settings-sectiont', [
            'user', $this->user, 
            'notification_setting', $this->notification_setting,
            'sound_setting',$this->sound_setting
        ]);
    }

    public function submit()
    {
        // update the user settings table
        $user = UserSettings::where('user_id', $this->user->id)->update([ 
            'notification_setting' => $this->notification_setting,
            'sound_setting' => $this->sound_setting,
        ]); 
        // return redirect()->route('profile.show', $user); 

    }
}
