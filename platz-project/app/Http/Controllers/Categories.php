<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorie;

class Categories extends Controller
{
    /**
     * Fonction qui permet d'obtenir toutes les Categories sous la forme JSON
     *
     * @return  [type]  [renvoie les Categories sous la forme JSON]
     */
    public function index() {
      return response()->json(Categorie::all());
    }
}
