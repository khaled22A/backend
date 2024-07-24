<?php

namespace App\Http\Controllers\API\Controlleur;

use App\Http\Controllers\Controller;
use App\Models\categorie;
use Illuminate\Http\Request;

class CategoriesControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cat=Categorie::all();
        return response()->json(['categorie'=>$cat],200);
    }

    /**
     * Show the form for creating a new resource.
     */
   
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom'=>'required|max:255',
            'description'=>'required|string|max:1000',
        ]);

        $cat = new Categorie();
 
        $cat->nom = $request->nom;
        $cat->description = $request->description;
 
        $cat->save();
        return response()->json(['message'=>'Categoriea a été bien créer'],200);

    }

    /**
     * Display the specified resource.
     */
    public function show(categorie $id)
    {
        $cat=Categorie::find($id);
        if(!$cat)
        {
            return response()->json(['message'=>'Categorie non trouvé'],404);
        }
        else
        {
            return response()->json(['categorie'=>$cat],200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
  

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, categorie $id)
    {
        $request->validate([
            'nom'=>'required|max:255',
            'description'=>'required|string|max:1000',
        ]);


        $cat = Categorie::find($id);
        if($cat)
        {
            $cat->nom = $request->nom;
            $cat->description = $request->description;
    
            $cat->update();
            return response()->json(['message'=>'categorie a été modifier'],200);

        }
        else
        {
            return response()->json(['message'=>'categorie non trouver'],404);

        }
      
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(categorie $id)
    {
        $cat=Categorie::find($id);
        if($cat)
        {
          $cat->delete();
          return response()->json(['message'=>'catégorie a été supprimer']);
        }
        else
        {
          return response()->json(['message'=>'categorie  non trouver'],404);
  
        }
    }
}
