<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;

class Conversations extends Controller
{
    /**
     * Fonction qui permet d'avoir toutes les Conversations sous la forme JSON
     */
    public function index() {
      return response()->json(Conversation::all());
    }

    /**
     * Fonction qui permet d'enregistrer un nouveau message dans la base de données
     *
     * @param   Request  $request  [$request description]
     *
     * @return  [type]             [return description]
     */
    public function addMessage(Request $request) {
      $conversation = new Conversation;
      $conversation->from_id = $request->from_id;
      $conversation->to_id = $request->to_id;
      $conversation->content = $request->content;

      $conversation->save();

      return response()->json([
        'statut' => 200,
        'message' => "Ajout conversation réussi"
      ]);
    }

    
}
