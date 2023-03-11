<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('profilepage.profile') }}
        </h2>
</x-slot>
<form wire:submit.prevent="update_practice">
    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>
    <label>
    {{ __('practicepage.title') }} :
        <input type="text" wire:model.delay.500ms="title" value="{{$title}}"/>
        @error('title') <span class="error text-red-500">{{ $message }}</span> @enderror
    </label>
    <label>
        {{ __('practicepage.description') }} :
        <textarea wire:model.delay.500ms="description">{{ $description }}</textarea>
    </label>
    @foreach($all_categories as $category)
        <label>
            <input wire:model="add_categories" value="{{ $category->id }}" type="checkbox"/>
            {{$category->id}}{{ $category->title }}
        </label>
    @endforeach
    <br><br>
    <input type="file" wire:model="new_file">
    @error('new_file.*') <span class="error">{{ $message }}</span> @enderror
    <button type="submit" class="border-solid border-2 border-indigo-600 py-4">{{ __('practicepage.update_practice') }}</button>
    {{ __('practicepage.current_filename') }}: {{ $original_file_name }} <br><br>


    @if ($new_file)
        {{ __('practicepage.new_file') }} :
        {{$new_file}}
        <iframe src="{{$new_file->temporaryUrl()}}" width="40%" height="200px;"></iframe>
            
    @else
        {{ __('practicepage.current_file') }} :
        <iframe src="{{$original_file}}" width="40%" height="200px;"></iframe>
    @endif</form>
<x-slot name="footer">
        @livewire('footer')
</x-slot>