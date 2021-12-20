@component('mail::message')
# Nouveau mot de passe {{ config('app.name') }}!

Nous voulions vous informer que votre mot de passe d'accès au compte {{ config('app.name') }} a été modifié.

Vos nouveaux identifiants de connexion sont les suivants:

Email: **{{ $notifiable->email }}**\
Mot de passe: **{{ $password }}**
@endcomponent

