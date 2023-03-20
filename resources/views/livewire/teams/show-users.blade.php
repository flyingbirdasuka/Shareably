<p class="font-semibold text-gray-800 p-6">{{ __('teamspage.show_users') }}</p>
<div class="flex flex-col px-6 py-5 bg-gray-50 overflow-scroll" style="height: 60vh;">
    <table class="text-sm text-left text-gray-500 border-gray-300">
        <tbody>
        @if(count($users) > 0)
        @foreach($users as $user)
                <tr class="bg-white border-b">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap flex justify-between">
                        <p><a href="/users/{{$user->id}}">{{ $user->id }}</a></p>
                        <p><a href="/users/{{$user->id}}">{{ $user->name }}</a></p>
                        <button class="px-4 py-2 text-white font-semibold bg-indigo-500 rounded"><a href="/users/{{$user->id}}">{{ __('teamspage.detail') }}</a></button>
                    </th>
                </tr>
        @endforeach
        @else
            <tr class="bg-white border-b">
                {{ __('teamspage.no_users') }}
            </tr>
        @endif
        </tbody>
    </table>
</div>
<div class="flex flex-row items-center justify-between p-5 border-t border-gray-200">
    <button wire:click="$emit('closeModal')" class="rounded">{{ __('teamspage.close') }}</button>
</div>