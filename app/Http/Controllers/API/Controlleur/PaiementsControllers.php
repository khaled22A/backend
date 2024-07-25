<?php

namespace App\Http\Controllers\API\Controlleur;

use App\Http\Controllers\Controller;
use App\Models\paiement;
use Illuminate\Http\Request;
use Carbon\Carbon;


class PaiementsControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pay= paiement::all();
        return response()->json(['paiement'=>$pay],200);
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_client' => 'required|integer|exists:clients,id', 
            'total' => 'required|numeric|min:0',
            'methode_paiement' => 'required|string|in:card,cash,other', 
            'date_paiement' => 'required|date',
            'statut'=>'required|string|in:en attente , valider, echoué, remboursé'
        ]);

        $currentDateTime = Carbon::now();

        $pay= new paiement();
        $pay->id_client=$request->id_client;
        $pay->total=$request->total;
        // $pay->methode_paiement=$request->methode_paiement;
        $pay->date_paiement=$currentDateTime;
        $pay->statut=$request->statut;

        $pay->save();
        return response()->json(['message'=>'paiement bien créer'],200);
      

    }

    /**
     * Display the specified resource.
     */
    public function show(paiement $id)
    {
        $pay=paiement::find($id);
        if($pay)
        {
            return response()->json(['paiement'=>$pay],200);

        }
        else
        {
        return response()->json(['message'=>'paiement non trouver'],404);

        }
    }

 

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, paiement $id)
    {
        $request->validate([
            'id_client' => 'required|integer|exists:clients,id', 
            'id_commande' => 'required|integer|exists:commandes,id',
            'total' => 'required|numeric|min:0',
            'methode_paiement' => 'required|string|in:card,cash,other', 
            'date_paiement' => 'required|date',
            'statut'=>'required|string|in:en attente , valider, echoué, remboursé'
        ]);

        $currentDateTime = Carbon::now();
        $pay=paiement::find($id);
        if($pay)
        {
            $pay->id_client=$request->id_client;
            $pay->total=$request->total;
            // $pay->methode_paiement=$request->methode_paiement;
            $pay->date_paiement=$currentDateTime;
            $pay->statut=$request->statut;
    
            $pay->update();
            return response()->json(['message'=>'paiement a été bien modifier'],200);
        }
        else
        {
            return response()->json(['message'=>'paiement non trouver'],404);
        }
      
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(paiement $id)
    {
        $pay=paiement::find($id);
       if($pay)
       {
        $pay->delete();
        return response()->json(['message'=>'paiement a été supprimer'],200);
       }
       else
       {
        return response()->json(['message'=>'paiement non trouver'],404);
       }
    }
}
