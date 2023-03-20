<form wire:submit.prevent="update_categories">
    <div>
        @if (session()->has('message'))
            <div class="alert">
                {{ session('message') }}
            </div>
        @endif
    </div>
    <p class="font-semibold text-gray-800 p-6">{{ __('categorypage.add_category') }}</p>
    <div class="flex flex-col px-6 py-5 bg-gray-50 overflow-scroll" style="height: 60vh;">
        <table class="text-sm text-left text-gray-500 border-gray-300">
            <tbody>
                @foreach($all_categories as $category)
                    <tr class="bg-white border-b hover:bg-gray-50 ">
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                            <input wire:model="categories" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500" value="{{ $category->id }}" >
                            </div>
                        </td>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                        {{$category->id}} : {{ $category->title }}
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
   <div class="flex flex-row items-center justify-between p-5 border-t border-gray-200">
        <button wire:click="$emit('closeModal')" class="rounded">{{ __('categorypage.close') }}</button>
        <button type="submit" class="px-4 py-2 text-white font-semibold bg-indigo-500 rounded">{{ __('categorypage.add') }}
        </button>
    </div>
</form>