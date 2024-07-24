<?php

namespace App\Http\Controllers\API\Controlleur;

use App\Http\Controllers\Controller;
use App\Models\client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientsControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clent=Client::all();
        return response()->json(['client'=>$clent],200);
    }

   public function store(Request $request)
    {
        $data = Validator::make($request->all(), [ 
            // 'id_user' => 'required|integer|exists:users,id',
            'id_commune' => 'required|integer|exists:communes,id', 
            'nom' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique',
            'telephone' => 'required|string|min:10|max:13|unique:clients,telephone',
            'adresse' => 'required|string|max:255',
            
        ]);
        
        if ($data->fails()) {
            return response()->json([
                "message" => $data->errors()->first()
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

        return response()->json(['message'=>'user bien créer',
        "Client" => $clent],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(client $id)
    {
        $clent=Client::find($id);
        if($clent)
        {
            return response()->json(['client'=>$clent],200);
            
        }
        else
        {
            return response()->json(['message'=>'client non trouver'],404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
   

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, client $id)
    {
        $request->validate([
            
            'id_commune' => 'required|integer|exists:communes,id', 
            'nom' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique',
            'telephone' => 'required|string|min:10|max:13',
            'adresse' => 'required|string|max:255',
           
        ]);


        $clent=Client::find($id);

        if($clent)
        {
            
           
            $clent->id_commune = $request->id_commune;
            $clent->nom = $request->nom;
            $clent->email = $request->email;
            $clent->telephone = $request->telephone;
            $clent->adresse = $request->adresse;
          

            $clent->update();
            return response()->json(['message'=>'les informations on  été modifier'],200);
        } 
        else
            {
                return response()->json(['message'=>'client non trouver'],404);

            }
        return $clent;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(client $id)
    {
        $clent=Client::find($id);

        if($clent)
      {
        $clent->delete();
        return response()->json(['message'=>'client a été supprimer']);
      }
      else
      {
        return response()->json(['message'=>'client non trouver'],404);
      }
        
    
    }
}
