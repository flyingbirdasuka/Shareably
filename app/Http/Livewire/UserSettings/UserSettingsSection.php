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
    public $languages = [];
    public $language_options= [];

    public function mount()
    {
        $this->user = auth()->user();
        $this->language_options = Language::all();
        $this->user_settings = UserSettings::where('user_id', $this->user->id)->first();
        $this->fill([
            'notification_setting' => $this->user_settings->notification_setting, 
            'sound_setting' => $this->user_settings->sound_setting, 
            'languages' => $this->user_settings->language()->pluck('language_code')->unique()->values()
        ]);
    }

    public function render()
    {
        return view('livewire.user-settings.user-settings-sectiont', [
            'user', $this->user, 
            'notification_setting', $this->notification_setting,
            'sound_setting',$this->sound_setting, 
            'languages', $this->languages, 
            'language_options', $this->language_options]);
    }

    public function submit()
    {

        // update the user settings table
        $user = UserSettings::where('user_id', $this->user->id)->update([ 
            'notification_setting' => $this->notification_setting,
            'sound_setting' => $this->sound_setting,
        ]); 

        // update the user_settings_language table
        DB::table('user_settings_language')->where('user_settings_id', $this->user_settings->id)->delete(); // refresh the data for this user

        foreach ($this->languages as $language){
            $language_id = Language::where('language_code', $language)->first()->id;
            DB::table('user_settings_language')->insert(
                ['user_settings_id' => $this->user_settings->id, 'language_id' => $language_id],
            );
        }
        // return redirect()->route('profile.show', $user); 

    }
}
