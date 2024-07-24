<?php

namespace App\Http\Controllers\API\Controlleur;

use App\Http\Controllers\Controller;
use App\Models\commune;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CommunesControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cmn=Commune::all();
       return response()->json(['commnue'=>$cmn],200);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = Validator::make($request->all() , [
            'id_wilaya' => 'required|integer|exists:wilayas,id', // Validate existence in 'wilayas' table (assuming foreign key relationship)
            'nom' => 'required|string|max:255', // Maximum length for 'nom'
            'code_postal' => 'required|string|alpha_num', // Alphanumeric postal code
            
            
        ]); 

        if ($data->fails()) {
            return response()->json([
                "message" => $data->errors()->first()
            ],400 );
        }
        else
        {
            $cmn = Commune::create( [
                // 'id_user' => $request->id_user,
                'id_wilaya' => $request->id_wilaya, 
                'nom' =>$request->nom,
                'code_postal'=>$request->code_postal,
              
            ]);

            return response()->json(['message'=>'commune bien créer',
            "Commune" => $cmn],200);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(commune $id)
    {
        $cmn=Commune::find($id);
        if($cmn)
        {
            return response()->json(['commnue'=>$cmn],200);
        }
        else
        {
            return response()->json(['message'=>'commune non trouver'],404);    
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, commune $id)
    {
        $request->validate([
            'id_wilaya' => 'required|integer|exists:wilayas,id', // Validate existence in 'wilayas' table (assuming foreign key relationship)
            'nom' => 'required|string|max:255', // Maximum length for 'nom'
            'code_postal' => 'required|string|alpha_num', // Alphanumeric postal code
            'region' => 'required|string|max:255', // Maximum length for 'region'
        ]);

        $cmn=Commune::find($id);
        if($cmn)
        {
            $cmn->id_wilaya=$request->id_wilaya;
            $cmn->nom=$request->nom;
            $cmn->code_postal=$request->code_postal;
      
            $cmn->region=$request->region;

            $cmn->update();
            return response()->json(['message'=>'les informations on été modifier'],200);
        }
        else
        {
            return response()->json(['message'=>'commune non trouver'],404);
        }  
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(commune $id)
    {
        $cmn=Commune::find($id);
       if($cmn)
       {
        $cmn->delete();
        return response()->json(['message'=>'commune a été supprimer']);
      }
      else
      {
        return response()->json(['message'=>'commune non trouver'],404);
       }
    }
}
