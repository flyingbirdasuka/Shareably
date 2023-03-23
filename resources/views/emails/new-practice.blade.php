<x-mail::message>
# New Practice :)

The new practice "{{ $title }}"" is uploaded.

<x-mail::button :url="$url">
Try new practice 
</x-mail::button>

Hope you enjoy it!<br>
{{ config('app.name') }}
</x-mail::message>
