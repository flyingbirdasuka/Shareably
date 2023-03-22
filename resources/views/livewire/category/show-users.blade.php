<form wire:submit.prevent="delete()">

<p class="font-semibold text-gray-800 p-6">{{ __('categorypage.show_users') }}</p>
<div class="flex flex-col px-6 py-5 bg-gray-50 overflow-scroll" style="height: 60vh;">
    <table class="text-sm text-left text-gray-500 border-gray-300">
        <tbody>
        @if(count($users) > 0)
            @foreach($users as $user)
                    <tr class="bg-white border-b hover:bg-gray-50 ">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap flex justify-between items-center">
                            <p><a href="/users/{{$user->id}}">{{ $user->name }}</a></p>
                            <button type="submit" wire:click.prevent="$set('user_id', '{{ $user->id }}')" class="px-4 py-2 text-white font-semibold bg-indigo-500 rounded">{{ __('categorypage.remove') }}</button>
                        </th>
                    </tr>
            @endforeach
        @else
            <tr class=>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                    {{ __('categorypage.no_users') }}
                </th>
            </tr>
        @endif
        </tbody>
    </table>
</div>
<div class="flex flex-row items-center justify-between p-5 border-t border-gray-200">
    <button wire:click="$emit('closeModal')" class="rounded">{{ __('categorypage.close') }}</button>
</div>
</form>
