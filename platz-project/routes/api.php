<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Categories;
use App\Http\Controllers\Ressources;
use App\Http\Controllers\Users;
use App\Http\Controllers\Commentaires;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\Search;
use App\Http\Controllers\Conversations;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// API des Categories
// CTRL: Categories
Route::resource('categories', Categories::class)->except(['show', 'create', 'edit']);

// API des Ressources
// CTRL: Ressources
Route::resource('ressources', Ressources::class)->except(['show', 'create', 'edit']);

// API des Users
// CTRL: Users
Route::resource('users', Users::class)->except(['show', 'create', 'edit']);

// API des Commentaires
// CTRL: Commentaires
Route::resource('commentaires', Commentaires::class)->except(['show', 'create', 'edit']);

// Creation compte user
Route::post('/auth/register', [AuthenticationController::class, 'register']);

// Connexion compte user
Route::post('/auth/login', [AuthenticationController::class, 'login']);

// Deconnexion compte user
Route::post('/logout', [AuthenticationController::class, 'logout']);

// Recherche
// CTRL: Search
Route::get('/search', [Search::class, 'search']);


// Utilisation du middleware pour proteger la route et la rendre accessible uniquement aux users connectes
Route::group(['middleware' => ['auth:sanctum']], function() {
  // Ajout d'une ressource
  Route::post('/add', [Ressources::class, 'add']);
  // Edition d'une ressource
  Route::post('/edit', [Ressources::class, 'edit']);
  // Suppression d'une ressource
  Route::post('/delete', [Ressources::class, 'delete']);
  // Ajout d'un commentaire
  Route::post('/commentaires/add', [Commentaires::class, 'add']);
  // Edition du pseudo d'un utilisateur connect??
  Route::post('/my-profile/edit', [Users::class, 'edit']);
  // Conversations (syst??me de messagerie)
  // CTRL: Conversations
  Route::get('/conversations', [Conversations::class, 'index']);
  // Ajout d'un message ?? la conversation (syst??me de messagerie)
  Route::post('/conversations/add', [Conversations::class, 'addMessage']);
});
