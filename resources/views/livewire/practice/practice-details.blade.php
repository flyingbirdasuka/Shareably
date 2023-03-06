<div>
    Title : {{ $practice->title }}
    Description : {{ $practice->description }}
    Category :
    @if($categories)
        @foreach($categories as $category)
            {{ $category->id }}
        @endforeach
    @endif
    <iframe src="{{ $this->pdf }}" width="60%" height="600px;">
</div>
