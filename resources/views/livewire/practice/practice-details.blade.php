<x-slot name="header">
        <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $practice->title }}
        </h2>
        <button class="ml-4 bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded inline-flex items-center px-3 py-2 focus:outline-none transition ease-in-out duration-150"><a href="/practices/{{$practice->id}}/edit">{{ __('practicepage.edit') }}</a></button>
        </div>
</x-slot>
<div class="flex flex-col lg:flex-row lg:mb-6">
    <div class="flex flex-start flex-col w-full lg:w-1/2">
        <table>
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
        @if($video_id)
            <div class="embed-container mb-4">
                <iframe class="mt-6" src="https://www.youtube.com/embed/{{$video_id}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>
        @endif
        @if($music)
            <audio controls controlslist="nodownload" src="{{$music}}"></audio>
        @endif
    </div>
    <div class="container flex justify-center lg:flex-end mb-4">
        <iframe src="{{ $pdf }}#view=Fit" height="600" width="90%"></iframe>
    </div>
</div>
