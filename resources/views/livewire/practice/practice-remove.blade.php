<form wire:submit.prevent="delete">
    <p class="font-semibold text-gray-800 p-6">{{ __('practicepage.remove') }}</p>
    <div class="flex flex-col px-6 py-5 bg-gray-50">
        {{ __('practicepage.remove_confirmation_message') }}
    </div>
   <div class="flex flex-row items-center justify-between p-5 border-t border-gray-200">
        <button wire:click="$emit('closeModal')" class="rounded">{{ __('practicepage.close') }}</button>
        <button type="submit" class="px-4 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded">{{ __('practicepage.remove') }}
        </button>
    </div>
</form>