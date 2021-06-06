<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Events\MessageSent;

class Conversations extends Controller
{
    /**
     * Fonction qui permet d'avoir toutes les Conversations sous la forme JSON
     */
    public function index() {
      return response()->json(Conversation::all());
    }

    /**
     * Fonction qui permet d'enregistrer un nouveau message dans la base de données.
     * En cas de succès, envoi d'un statut 200 et d'un message confirmant l'envoi du message (conversation) dans le Network (Inspecteur)
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

      broadcast(new MessageSent($conversation));

      return response()->json([
        'statut' => 200,
        'message' => "Ajout conversation réussi"
      ]);
    }

    
}
