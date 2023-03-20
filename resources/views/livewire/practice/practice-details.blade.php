<x-slot name="header">
        <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $practice->title }}
        </h2>
        <button class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center px-3 py-2 focus:outline-none transition ease-in-out duration-150"><a href="/practices/{{$practice->id}}/edit">{{ __('practicepage.edit') }}</a></button>
        </div>
</x-slot>
<div class="flex flex-col container lg:flex-row">
    <table class="flex flex-start w-full lg:w-1/2">
        <tr>
            <x-table-data><b>{{ __('categorypage.description') }}</b> : {{ $practice->description }}</x-table-data>
        </tr>
        <tr>
            <x-table-data><b>{{ __('categorypage.categorypage_title') }}</b> : </x-table-data>
        </tr>
        @if(count($categories) > 0)
            @foreach($categories as $category)
                <x-table-row>
                    <x-table-data><a href="/categories/{{$category->id}}">{{ $category->title }}</a></x-table-data>
                </x-table-row>
            @endforeach
        @else
            <x-table-data>{{__('categorypage.no_category')}}</x-table-data>
        @endif
    </table>
    <div class="container flex justify-center lg:flex-end mb-4">
        <iframe src="{{ $this->pdf }}#view=Fit" height="600" width="90%"></iframe>
    </div>
</div>
