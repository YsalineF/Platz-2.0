<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class Users extends Controller
{
    /**
     * Fonction qui permet d'avoir toutes les Users sous la forme JSON
     *
     * @return  [type]  [renvoie les Users sous la forme JSON]
     */
    public function index() {
      return response()->json(User::all());
    }

    /**
     * Fonction qui permet l'édition du pseudo de l'utilisateur connecté
     *
     * @param   Request  $request  [$request description]
     *
     * @return  [type]             [renvoie un JSON content un statut (200) et un message confirmant l'édition du user]
     */
    public function edit(Request $request) {
      $user = User::find($request->id);
      $user->name = $request->name;
      $user->email = $request->email;
      $user->description = $request->description;
      $user->facebook = $request->facebook;
      $user->linkedin = $request->linkedin;

      // Vérification du fichier pour l'image
      if ($request->file('image')) {
        $image = $request->file('image');
        $imageUser = $image->getClientOriginalName();
        $image->move(public_path('assets/img'), $imageUser);
        $user->image = $imageUser;
      }
      // Si pas d'image, affichage d'une image par défaut
      else {
        $user->image = "avatar.png";
      }
      $user->save();

      return response()->json([
        'statut' => 200,
        'message' => "Edition réussie"
      ]);
    }
}
