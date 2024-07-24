<?php

namespace App\Http\Controllers\API\Controlleur;

use App\Http\Controllers\Controller;
use App\Models\lignecommande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class LignesControllers extends Controller
{
    public function index()
    {
        return  DB::table('lignecommandes')
            ->select('lignecommandes.id','lignecommandes.id_commande','lignecommandes.quantite','lignecommandes.prix','lignecommandes.total','produits.nom')
            ->join('produits','produits.id','=','lignecommandes.id_produit')
            ->get();

       $ligne= lignecommande::all();
       return response()->json(['ligne de commande'=>$ligne],200);

       
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_commande' => 'required|integer|exists:commandes,id',
            'id_produit' => 'required|integer|exists:produits,id',
            'prix' => 'required|numeric|min:0',
            'quantite' => 'required|integer|min:1',
            'total' => 'required|numeric|min:0',
        ]);

        $ligne= new lignecommande();
        $ligne->id_commande=$request->id_commande;
        $ligne->id_produit=$request->id_produit;
        $ligne->prix=$request->prix;
        $ligne->quantite=$request->quantite;
        $ligne->total=$request->total;

        $ligne->save();
        return response()->json(['message'=>'ligne de commande créer'],200);


    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $ligne=lignecommande::find($id);
        if($ligne)
        {
            return response()->json(['ligne de commande'=>$ligne],200);

        }
        else
        {
       return response()->json(['message'=>'ligne de commande non trouver'],200);

        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'id_commande' => 'required|integer|exists:commandes,id',
            'id_produit' => 'required|integer|exists:produits,id',
            'prix' => 'required|numeric|min:0',
            'quantite' => 'required|integer|min:1',
            'total' => 'required|numeric|min:0',
        ]);

        $ligne= lignecommande::find($id);
        if($ligne)
        {
            $ligne->id_commande=$request->id_commande;
            $ligne->id_produit=$request->id_produit;
            $ligne->prix=$request->prix;
            $ligne->quantite=$request->quantite;
            $ligne->total=$request->total;
    
            $ligne->update();
            return response()->json(['message'=>'les informations on été modifier'],200); 
        }
        else
        {
            return response()->json(['message'=>'ligne de commande non trouver'],200); 

        }  

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $ligne=lignecommande::find($id);
        if($ligne)
        {
            $ligne->delete();
            return response()->json(['message'=>'ligne de commande a été supprimer'],200); 
        }
        else
        {
            return response()->json(['message'=>'ligne de commande non trouver'],404); 

        }
    }

}
