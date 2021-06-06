<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ressource;

class Search extends Controller
{
    /**
     * Fonction qui permet d'effectuer des recherches sur le nom d'une ressource via la barre de recherche 
     *
     * @param   Request  $request  [$request description]
     *
     * @return  [type]             [return description]
     */
    public function search(Request $request) {
        // Inspiration : https://www.php.net/manual/fr/function.preg-split.php
        // PREG_SPLIT_NO_EMPTY ==> permet de retourner les sous-chaînes non vides
        $searchValues = preg_split("/[\s,]+/", $request->searchValue, -1, PREG_SPLIT_NO_EMPTY);

        $ressources = Ressource::where(function ($z) use ($searchValues){
            foreach($searchValues as $searchValue) {
                $z->orWhere('nom', 'like', "%" . $searchValue . "%");
            }
        })->get();
        return response()->json($ressources);
    }

    
}
