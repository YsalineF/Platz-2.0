<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ressource;

class Ressources extends Controller
{
    /**
     * Fonction qui permet d'avoir toutes les Ressources sous la forme JSON
     *
     * @return  [type]  [renvoie les Ressources sous la forme JSON]
     */
    public function index() {
      return response()->json(Ressource::all());
    }

    /**
     * Fonction qui permet d'ajouter une ressource à la DB
     * On crée d'un nouvel objet de type Ressource et on le "remplit" avec les éléments du formulaire rempli
     * En cas de succès, envoi d'un statut 200 et d'un message confirmant l'envoi de la ressource dans le Network (Inspecteur)
     *
     * @param   Request  $request  [$request description]
     *
     * @return  [type]             [renvoie un JSON content un statut (200) et un message confirmant l'ajout de la ressource]
     */
    public function add(Request $request) {
      $ressource = new Ressource;
      $ressource->nom = $request->nom;
      $ressource->description = $request->description;

      // Inspiration : projet laravel basica
      if($request->file('image')) {
        $image = $request->file('image');
        $imageRessource = $image->getClientOriginalName();
        $image->move(public_path('assets/img'), $imageRessource);
        $ressource->image = $imageRessource;
      }
      $ressource->size = $request->size;
      $ressource->categorie_id = $request->categorie;
      $ressource->user_id = $request->user;
      $ressource->save();

      return response()->json([
        'statut' => 200,
        'message' => "Ajout réussi"
      ]);
    }

    /**
     * Fonction qui permet d'éditer une ressource en modifiant les éléments de la db avec les nouveaux éléments
     * et qui permet le traitement d'une image afin que l'image en question se retrouve dans le dossier "assets/img"
     *
     * @param   Request  $request  [$request description]
     *
     * @return  [type]             [return description]
     */
    public function edit(Request $request) {
      $ressource = Ressource::find($request->id);
      $ressource->nom = $request->nom;

      // Traitement de l'image
      if ($request->file('image')) {
        $image = $request->file('image');
        $imageRessource = $image->getClientOriginalName();
        $image->move(public_path('assets/img'), $imageRessource);
        $ressource->image = $imageRessource;
      }
      $ressource->description = $request->description;
      $ressource->categorie_id = $request->categorie;
      $ressource->user_id = $request->user;
      $ressource->updated_at = NOW();
      $ressource->save();
    }

    /**
     * Fonction qui permet de supprimer une ressource
     *
     * @param   Request  $request  [$request description]
     *
     * @return  [type]             [return description]
     */
    public function delete(Request $request) {
      $ressource = Ressource::find($request->id);
      $ressource->delete();
    }
}
