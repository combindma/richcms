@component('mail::message')
# Bienvenue sur {{ config('app.name') }}!

Votre compte a été ajouté automatiquement avec succès.

Nous sommes heureux de vous accueillir parmi nous. Vos identifiants de connexion sont les suivants:

Email: **{{ $notifiable->email }}**\
Mot de passe: **{{ $password }}**

@endcomponent

