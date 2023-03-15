<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $practice->title }}
        </h2>
</x-slot>
<div>
{{ __('categorypage.title') }}: {{ $practice->title }}
{{ __('categorypage.description') }}: {{ $practice->description }}
{{ __('categorypage.category') }}:
    @if($categories)
        @foreach($categories as $category)
            {{ $category->id }}
            {{ $category->title }}
        @endforeach
    @endif
    <iframe src="{{ $this->pdf }}" width="60%" height="600px;">
</div>
