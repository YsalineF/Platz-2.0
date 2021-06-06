<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class Users extends Controller
{
    public function index() {
      return response()->json(User::all());
    }

    /**
     * [editPseudo fonction qui permet l'édition du pseudo de l'utilisateur connecté]
     *
     * @param   Request  $request  [$request description]
     *
     * @return  [type]             [return description]
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
