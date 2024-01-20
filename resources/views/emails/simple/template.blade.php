@component('mail::message')
# {{$name}}

{!! $message !!}

Thanks,<br>
{{ config('settings.product_name') }} Team
@endcomponent