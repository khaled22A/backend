<?php

namespace App\Http\Controllers\API\Controlleur;

use App\Http\Controllers\Controller;
use App\Models\panier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaniersControllers extends Controller
{
    public function index()
    {
        $paniers = Panier::all();
        return response()->json($paniers, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_client' => 'required|integer|exists:clients,id', // Validate client ID
            'id_produit' => 'required|integer|exists:produits,id', // Validate product ID
            'quantite' => 'required|integer|min:1', // Validate quantity (positive)
            'prix' => 'required|integer|min:0', // Validate price (non-negative)
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $request->only(['id_client', 'id_produit', 'quantite', 'prix']);

        // Check if item already exists in cart
        $existingItem = Panier::where('id_client', $data['id_client'])
            ->where('id_produit', $data['id_produit'])
            ->first();

        if ($existingItem) {
            $existingItem->quantite += $data['quantite']; // Update quantity
            $existingItem->save();

            return response()->json([
                'message' => 'Produit mis à jour dans le panier.', // French message
                'panier_item' => $existingItem,
            ], 200);
        }

        $panierItem = Panier::create($data);

        return response()->json([
            'message' => 'Produit ajouté au panier avec succès!', // French message
            'panier_item' => $panierItem,
        ], 201);
    }

    /**
     * Display the specified cart item.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $panierItem = Panier::find($id);

        if (!$panierItem) {
            return response()->json(['message' => 'Panier item not found'], 404);
        }

        return response()->json($panierItem, 200);
    }

    /**
     * Update the specified cart item in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_client' => 'required|integer|exists:clients,id', // Validate client ID
            'id_produit' => 'required|integer|exists:produits,id', // Validate product ID
            'quantite' => 'required|integer|min:1', // Validate quantity (positive)
            'prix' => 'required|integer|min:0', // Validate price (non-negative)
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $panierItem = Panier::find($id);

        if (!$panierItem) {
            return response()->json(['message' => 'Panier item not found'], 404);
        }

        $panierItem->update($request->all());

        return response()->json(['message' ,'Panier item updated successfully!'], 200);
    }

    /**
     * Remove the specified cart item from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $panierItem = Panier::find($id);

        if (!$panierItem) {
            return response()->json(['message' => 'Panier item not found'], 404);
        }

        $panierItem->delete();

        return response()->json(['message' => 'Panier item deleted successfully!'], 200);
    }
}
