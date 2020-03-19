@component('mail::message')
# Aprendendo laravel

Muito massa, lembre-se sempre de reiniciar o servidor quando mudar o .env!

@component('mail::button', ['url' => 'https://www.youtube.com/watch?v=ImtZ5yENzgE'])
Clique aqui para aprender mais
@endcomponent

Flw Vlw,<br>
{{ config('app.name') }}
@endcomponent
