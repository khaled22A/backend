<?php

namespace App\Http\Controllers\API\Controlleur;

use App\Http\Controllers\Controller;
use App\Models\commande;
use App\Models\lignecommande;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;


class CommandesControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return  DB::table('commandes')
        ->select('commandes.id','commandes.num_commande','commandes.date_commande','clients.id as idClient','clients.nom','clients.email','clients.telephone','clients.adresse','commandes.statut')
        ->join('clients','clients.id','=','commandes.id_client')
        ->get();

    return Commande::all();
    }

    public function store(Request $request)
    {

                // Ajouter client

        $dataClient = Validator::make($request->all(), [ 
            // 'id_user' => 'required|integer|exists:users,id',
            'id_commune' => 'required|integer|exists:communes,id', 
            'nom' => 'required|string|max:255',
            'prenom' => 'required||string|max:255',
            'telephone' => 'required|string|min:10|max:13', //|unique:clients,telephone',
            'adresse' => 'required|string|max:255',
            
        ]);
        
        if ($dataClient->fails()) {
            return response()->json([
                "message" => $dataClient->errors()->first()
            ],400 );
        }
        else
        {
            $clent = new Client();
            $clent->id_commune = $request->id_commune;
            $clent->nom = $request->nom;
            $clent->email = $request->email;
            $clent->telephone = $request->telephone;
            $clent->adresse = $request->adresse;
           
            $clent->save();
        }

        $randomCode = Str::random(10);
        $currentDateTime = Carbon::now();
        $com= Commande::create ([
            'id_produit' =>$request->id_produit,
            'id_client' => $clent->id,
            'num_commande' =>$randomCode,
            'date_commande'=>$currentDateTime,
            // 'date_livraison'=>$request->date_livraison,
            'statut' => 'en_cours' //$request->statut,
            // 'mode_livraison'=>$request->mode_livraison
        ]);

        // $request->validate([
        //     'id_commande' => 'required|integer|exists:commandes,id',
        //     'id_produit' => 'required|integer|exists:produits,id',
        //     'prix' => 'required|numeric|min:0',
        //     'quantite' => 'required|integer|min:1',
        //     'total' => 'required|numeric|min:0',
        // ]);

        foreach ($request->products as $productData) {
        
            $ligne= new lignecommande();
            $ligne->id_commande=$com->id;
            $ligne->id_produit=$productData['id'];
            $ligne->prix=$productData['prix'];
            $ligne->quantite=$productData['quantity'];
            $ligne->total=$productData['prix']*$productData['quantity'];
    
            $ligne->save();
        
        }

        

        return response()->json(['message'=>'commande bien créer',"commande"=>$com],200);

        // *****************
        
        $data = Validator::make($request->all(), [
          'id_client' => 'required|integer|exists:clients,id',
          'id_produit' => 'required|integer|exists:produits,id',
            // 'num_commande' => 'required|string|unique:commandes,num_commande',
            // 'date_commande' => 'required|date ', 
            // 'date_livraison' => 'nullable|date:Y-M-D HH:MM:SS', 
            'statut' => 'required|in:en_cours,en_attente,livrée,annulée', 
            // 'mode_livraison' => 'required|in:domicile,local,rendez_vous', 
        ]);
        if ($data->fails()) {
            return response()->json($data->errors(), 400); 
        }
        else
        {
            
            // Get id client

            // Ajouter commande
            $randomCode = Str::random(10);
            $currentDateTime = Carbon::now();
            $com= Commande::create ([
                'id_user' =>$request->id_user,
                'id_client' => $clent->id,
                'num_commande' =>$randomCode,
                'date_commande'=>$currentDateTime,
                'statut' => $request->statut,
               
            ]);
        }

       // $com = new Commande();
        //$com->id_client = $request->id_client;
        //$com->num_commande = $request->num_commande;
        //$com->date_commande = $request->date_commande;
        //$com->etat_commande = $request->etat_commande;
        //$com->adresse_livraison = $request->adresse_livraison;
        
        //$com->save();
        return response()->json(['message'=>'commande bien créer',"commande"=>$com],200);


    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $com=Commande::find($id);
        if($com)
        {
             return response(['commande'=>$com],200);
               
        }
        else
        {
            return response(['message'=>'commande non trouver'],404);

        }
        
    }

  
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'id_client' => 'required|integer|exists:clients,id',
            'num_commande' => 'required|string|unique:commandes,num_commande',
            'date_commande' => 'required|date:Y-M-D HH:MM:SS ', 
            // 'date_livraison' => 'nullable|date:Y-M-D HH:MM:SS', 
            'statut' => 'required|in:en_cours,en_attente,livrée,annulée', 
            // 'mode_livraison' => 'required|in:domicile,local,rendez_vous', 
        ]);

        $com= Commande::find($id);
        if($com)
        {
            $com->id_client = $request->id_client;
            $com->num_commande = $request->num_commande;
            $com->date_commande =$request->date_commande;
            // $com->date_livraison =$request->date_livraison;
            $com->statut = $request->statut;
            // $com->mode_livraison = $request->mode_livraison;
            
            $com->update();
            return response(['message'=>'les infromations on été modifier'],200);
        }
        else
        {
            return response(['message'=>'commande non trouver'],404);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       $com=Commande::find($id);
 
       if($com)
       {
         $com->delete();
         return response()->json(['message'=>'commande a été supprimer']);
       }
       else
       {
         return response()->json(['message'=>'commande non trouver'],404);
 
       }
    }

   
}
