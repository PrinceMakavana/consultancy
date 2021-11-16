
@component('mail::message')
# Introduction

The body of your message.

@component('mail::button', ['url' => ''])
Button Text (<?= !empty($user['email']) ? $user['email'] : "No Emil" ?>)
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
