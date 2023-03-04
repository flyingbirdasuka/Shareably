<div>

        Settings
  
    <form wire:submit.prevent="submit">
        <label>
            <input type="radio" wire:model="notification_setting" value="0">
            Off
        </label>
        <label>    
            <input type="radio" wire:model="notification_setting" value="1">
            On
        </label> <br>
        <label>
            <input type="radio" wire:model="sound_setting" value="0">
            Off
        </label>
        <label>    
            <input type="radio" wire:model="sound_setting" value="1">
            On
        </label> <br>

        @foreach($language_options as $option)
            <input wire:model="languages" value="{{ $option->language_code }}" type="checkbox"/>
            {{ $option->language }} 
        @endforeach
 
        <button type="submit">Save</button>
    </form>
</div>

