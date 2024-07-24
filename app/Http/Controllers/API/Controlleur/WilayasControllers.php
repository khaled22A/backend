<?php

namespace App\Http\Controllers\API\Controlleur;

use App\Http\Controllers\Controller;
use App\Models\wilaya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WilayasControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
   /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $wil=Wilaya::all();
       return response()->json(['wilaya'=>$wil],200);
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

       $data =Validator::make($request->all(),[
        'nom' => 'required|string|max:255',
        'code_wilaya' => 'required|string|max:2|unique:wilayas,code_wilaya', 
       ]);
          
       if ($data->fails()) {
        return response()->json([
            "message" => $data->errors()->first()
        ],400 );
    }else
    {
        $wil= Wilaya::create([
            'nom'=> $request->nom,
            'code_wilaya'=>$request->code_wilaya,
        ]);
        return response()->json(['message'=>'wilaya bien crée',
        "Wilaya" => $wil],200);
    
    }
     
 
        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $wil=Wilaya::find($id);
        if($wil)
        {
            return response()->json(['wilaya'=>$wil],200);

        }
        else
        {
            return response()->json(['message','wilaya non trouver'],404);

        }
        return $wil;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate
        ([
        'nom' => 'required|string|max:255',
        'code_wilaya' => 'required|string|max:20|unique:wilayas,code_wilaya', 
        ]);

        $wil=Wilaya::find($id);
        if($wil)
        {
            $wil->nom = $request->nom;
            $wil->code_wilaya = $request->code_wilaya;
 
             $wil->update();
            return response()->json(['message'=>'les informations on  été modifier'],200); 
        }
        else
        {
            return response()->json(['message'=>'wilaya non trouver'],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       $wil= Wilaya::find($id);
       if($wil)
       {
         $wil->delete();
         return response()->json(['message'=>'wilaya a été supprimer']);
       }
       else
       {
         return response()->json(['message'=>'wilaya non trouver'],404);
 
       }
    }
}
