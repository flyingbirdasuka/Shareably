<x-slot name="header">
        <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $practice->title }}
        </h2>
        @if($is_admin)
            <button class="ml-4 bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded inline-flex items-center px-3 py-2 focus:outline-none transition ease-in-out duration-150"><a href="/practices/{{$practice->id}}/edit">{{ __('practicepage.edit') }}</a></button>
        @endif
        </div>
</x-slot>
<div class="flex flex-col lg:flex-row lg:mb-6">
    <div class="flex flex-start flex-col w-full mx-2 lg:w-1/2">
        <table>
            <tr>
                <x-table-data><b>{{ __('practicepage.description') }}</b> : {!! html_entity_decode($practice->description) !!}</x-table-data>
            </tr>
            <tr>
                <x-table-data><b>{{ __('practicepage.category') }}</b> : </x-table-data>
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
            <div class="embed-container mb-4 ">
                <iframe class="mt-6" src="{{$video_id}}" title="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen style="height:90%; width:100%; overflow:hidden;"></iframe>
            </div>
        @endif
        @if($music)
            <audio controls controlslist="nodownload" src="{{$music}}"></audio>
        @endif
    </div>
    <div class="container flex justify-center h-screen w-full mx-2 lg:w-1/2 lg:h-screen mb-4">
        <iframe src="{{ $pdf }}#view=Fit" style="height:100vh; width:90%;" ></iframe>
    </div>
</div>
