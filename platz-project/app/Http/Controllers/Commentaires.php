<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commentaire;
use App\Events\CommentAdded;

class Commentaires extends Controller
{
  public function index(){
    //return response()->json(Commentaire::all());
    return response()->json(Commentaire::with('ressource')->with('user')->get());
  }

  // Fonction qui permet l'ajout d'un commentaire
  public function add(Request $request) {
    $commentaire = new Commentaire();
    $commentaire->content = $request->comment;
    $commentaire->user_id = $request->user;
    $commentaire->ressource_id = $request->ressource;
    $commentaire->updated_at = null;
    $commentaire->save();

    broadcast(new CommentAdded($commentaire));

    return response()->json([
      'statut' => 200,
      'message' => "Ajout commentaire réussi"
    ]);

  }
}
