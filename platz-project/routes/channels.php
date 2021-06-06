<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Broadcast le channel pour la discussion instantanée
Broadcast::channel('conversation', function ($user) {
    return $user;
});

// Broadcast le channel pour l'ajout de commentaires
Broadcast::channel('commentaire', function ($user) {
    return $user;
});
