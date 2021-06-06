<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commentaire;
use App\Events\CommentAdded;

class Commentaires extends Controller
{
  /**
   * Fonction qui permet d'avoir tous les Commentaires sous la forme d'un objet JSON
   *
   * @return  [type]  [renvoie les Commentaires sous la forme JSON]
   */
  public function index(){
    //return response()->json(Commentaire::all());
    return response()->json(Commentaire::with('ressource')->with('user')->get());
  }

  /**
   * Fonction qui permet l'ajout d'un commentaire à la base de données
   * en créant un nouvel objet Commentaire.
   * Permet également l'affichage instantané du commentaire sur le site via le broadcast (ligne 34).
   * En cas de succès, envoi d'un statut 200 et d'un message confirmant l'envoi du commentaire dans le Network (Inspecteur)
   *
   * @param   Request  $request  [$request description]
   *
   * @return  [type]             [renvoie un JSON content un statut (200) et un message confirmant l'ajout du commentaire]
   */
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
