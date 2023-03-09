@component('mail::message')
{{ __('emailtemplate.team_invite', ['team' => $invitation->team->name]) }}

@if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::registration()))
{{ __('emailtemplate.no_account') }}

@component('mail::button', ['url' => route('register')])
{{ __('emailtemplate.create_account') }}
@endcomponent

{{ __('emailtemplate.accept') }}

@else
{{ __('emailtemplate.accept_click') }}
@endif


@component('mail::button', ['url' => $acceptUrl])
{{ __('emailtemplate.accept_invitation') }}
@endcomponent

{{ __('emailtemplate.discard') }}
@endcomponent
