<?php

namespace App\Http\Controllers\API\Controlleur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage; // For image handling (optional)
use App\Models\Produit;
use App\Models\Categorie; // Ass

    class ProduitsControllers extends Controller
    {
        /**
         * Display a listing of the products.
         *
         * @return \Illuminate\Http\JsonResponse
         */
        public function index()
        {
            $produits = Produit::with('categorie')->get(); // Eager load categorie data
            return response()->json($produits, 200);
        }
    
        /**
         * Store a newly created product in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\JsonResponse
         */
        public function store(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'id_categorie' => 'required|integer|exists:categories,id', // Validate categorie ID
                'nom' => 'required|string|max:255',
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image (optional)
                'quantite' => 'required|integer|min:0', // Validate quantity (non-negative)
                'prix' => 'required|integer|min:0', // Validate price (non-negative)
            ]);
    
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
    
            $data = $request->only([
                'id_categorie', 'nom', 'description', 'quantite', 'prix',
            ]);
    
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/produits', $imageName); // Store in /storage/app/public/produits
                $data['image'] = $imageName;
            }
    
            $produit = Produit::create($data);
    
            return response()->json([
                'message' => 'Produit créé avec succès!', // French message
                'produit' => $produit,
            ], 201);
        }
    
        /**
         * Display the specified product.
         *
         * @param  int  $id
         * @return \Illuminate\Http\JsonResponse
         */
        public function show($id)
        {
            $produit = Produit::with('categorie')->find($id);
    
            if (!$produit) {
                return response()->json(['message' => 'Produit introuvable.'], 404); // French message
            }
    
            return response()->json($produit, 200);
        }
    
        /**
         * Update the specified product in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\JsonResponse
         */
    public function update(Request $request, $id)
    {
    $validator = Validator::make($request->all(), [
        'id_categorie' => 'nullable|integer|exists:categories,id', // Allow updating categorie ID
        'nom' => 'string|max:255', // Optional update for nom
        'description' => 'string', // Optional update for description
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate updated image (optional)
        'quantite' => 'integer|min:0', // Optional update for quantity (non-negative)
        'prix' => 'integer|min:0', // Optional update for price (non-negative)
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    $produit = Produit::find($id);

    if (!$produit) {
        return response()->json(['message' => 'Produit introuvable.'], 404); // French message for product not found
    }

    $data = $request->only([
        'id_categorie', 'nom', 'description', 'quantite', 'prix',
    ]);

    // Handle image update (optional)
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/produits', $imageName); // Store in /storage/app/public/produits

        // Delete previous image if it exists (assuming unique filenames)
        if ($produit->image) {
            Storage::delete('public/produits/' . $produit->image);
        }

        $data['image'] = $imageName;
    }

        $produit->update($data); // Update product using mass assignment

            return response()->json([
            'message' => 'Produit mis à jour avec succès!', // French message for successful update
            'produit' => $produit,
         ], 200);
    }

    public function destroy($id)
    {
     $produit = Produit::find($id);

        if (!$produit) {
         return response()->json(['message' => 'Produit introuvable.'], 404); // French message for product not found
        }


     $produit->delete();

        return response()->json(['message' => 'Produit supprimé avec succès!',], 200); // French message for successful deletion
    }


 }

        