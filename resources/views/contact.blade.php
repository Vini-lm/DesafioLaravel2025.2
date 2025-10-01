@extends('layouts.mail') 

<x-mail::message>
# Nova Mensagem de Contato

Você recebeu uma nova mensagem de contato através do formulário do site.

## Mensagem:
<p>{{ $data['message'] }}</p>

</x-mail::message>
