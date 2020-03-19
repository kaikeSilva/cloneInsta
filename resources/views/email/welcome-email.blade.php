@component('mail::message')
# Aprendendo laravel

Muito massa!

@component('mail::button', ['url' => 'https://www.youtube.com/watch?v=ImtZ5yENzgE'])
Clique aqui para aprender mais
@endcomponent

Flw Vlw,<br>
{{ config('app.name') }}
@endcomponent
