<div>
    Title : {{ $practice->title }}
    Description : {{ $practice->description }}
    Category :
    @foreach($categories as $category)
        {{ $category->id }}
    @endforeach
    <iframe src="{{ $this->pdf }}" width="60%" height="600px;">
</div>
