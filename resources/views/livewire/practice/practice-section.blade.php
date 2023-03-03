<div>
    <label>
        <input type="checkbox" wire:model="editable"/>
    </label>
    @foreach ($practices as $practice)
        <a href="practices/{{$practice->id}}">
            <livewire:practice.practice-component :practice="$practice" :key="now() . $practice->id" :editable="$editable">
        </a>
    @endforeach
</div>