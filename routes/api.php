<?php

use Illuminate\Http\Request;
use App\Http\Controllers\API\Controlleur\CategoriesControllers;
use App\Http\Controllers\API\Controlleur\ClientsControllers;
use App\Http\Controllers\API\Controlleur\UsersControllers;
use App\Http\Controllers\API\Controlleur\ProduitsControllers;
use App\Http\Controllers\API\Controlleur\PaiementsControllers;
use App\Http\Controllers\API\Controlleur\PaniersControllers;
use App\Http\Controllers\API\Controlleur\CommandesControllers;
use App\Http\Controllers\API\Controlleur\CommunesControllers;
use App\Http\Controllers\API\Controlleur\WilayasControllers;
use App\Http\Controllers\API\Controlleur\LignesControllers;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/users',[UsersControllers::class, 'index']);
Route::get('/users/{id}',[UsersControllers::class, 'show']);
Route::post('/users',[UsersControllers::class, 'store']);
Route::put('/users/{id}',[UsersControllers::class, 'update']);
Route::delete('/users/{id}',[UsersControllers::class, 'destroy']);

// Admins route api
//Route::resource('admins',AdminsControllers::class);

// Route::get('/admins',[AdminsControllers::class, 'index']);
// Route::get('/admins/{id}',[AdminsControllers::class, 'show']);
// Route::post('/admins',[AdminsControllers::class, 'store']);
// Route::put('/admins/{id}',[AdminsControllers::class, 'update']);
// Route::delete('/admins/{id}',[AdminsControllers::class, 'destroy']);

//Wilayas route api
// Route::resource('wilayas',WilayasControllers::class);

Route::get('/wilayas',[WilayasControllers::class, 'index']);
Route::get('/wilayas/{id}',[WilayasControllers::class, 'show']);
Route::post('/wilayas',[WilayasControllers::class, 'store']);
Route::put('/wilayas/{id}',[WilayasControllers::class, 'update']);
Route::delete('/wilayas/{id}',[WilayasControllers::class, 'destroy']);

//Communes route api
// Route::resource('communes',CommnueControllers::class);

Route::get('/communes',[CommunesControllers::class, 'index']);
Route::get('/communes/{id}',[CommunesControllers::class, 'show']);
Route::post('/communes',[CommunesControllers::class, 'store']);
Route::put('/commnues/{id}',[CommunesControllers::class, 'update']);
Route::delete('/communes/{id}',[CommunesControllers::class, 'destroy']);


// Clients route api
// Route::resource('clients',ClientsControllers::class);

Route::get('/clients',[ClientsControllers::class, 'index']);
Route::get('/clients/{id}',[ClientsControllers::class, 'show']);
Route::post('/clients',[ClientsControllers::class, 'store']);
Route::put('/clients/{id}',[ClientsControllers::class, 'update']);
Route::delete('/clients/{id}',[ClientsControllers::class, 'destroy']);


// Commandes route api
// Route::resource('commandes',CommandeControllers::class);

Route::get('/commandes',[CommandesControllers::class, 'index']);
Route::get('/commandes/{id}',[CommandesControllers::class, 'show']);
Route::post('/commandes',[CommandesControllers::class, 'store']);
Route::put('/commandes/{id}',[CommandesControllers::class, 'update']);
Route::delete('/commandes/{id}',[CommandesControllers::class, 'destroy']);

// Categories route api
//Route::resource('categories',CategoriesControllers::class);

Route::get('/categories',[CategoriesControllers::class, 'index']);
Route::get('/categories/{id}',[CategoriesControllers::class, 'show']);
Route::post('/categories',[CategoriesControllers::class, 'store']);
Route::put('/categories/{id}',[CategoriesControllers::class, 'update']);
Route::delete('/categories/{id}',[CategoriesControllers::class, 'destroy']);

//Paiements route api
Route::get('/paiements',[PaiementsControllers::class, 'index']);
Route::get('/paiements/{id}',[PaiementsControllers::class, 'show']);
Route::post('/paiements',[PaiementsControllers::class, 'store']);
Route::put('/paiements/{id}',[PaiementsControllers::class, 'update']);
Route::delete('/paiements/{id}',[PaiementsControllers::class, 'destroy']);


// Produits route api

// Route::resource('produits',ProduitsControllers::class);
//  Route::get('/produits/chercher/{nom}',[ProduitController::class, 'chercher']);
Route::get('/produits',[ProduitsControllers::class, 'index']);
Route::get('/produits/{id}',[ProduitsControllers::class, 'show']);
Route::post('/produits',[ProduitsControllers::class, 'store']);
Route::put('/produits/{id}',[ProduitsControllers::class, 'update']);
Route::delete('/produits/{id}',[ProduitsControllers::class, 'destroy']);

//Panniers route api
Route::get('/panniers',[PaniersControllers::class, 'index']);
Route::get('/panniers/{id}',[PaniersControllers::class, 'show']);
Route::post('/panniers',[PaniersControllers::class, 'store']);
Route::put('/panniers/{id}',[PaniersControllers::class, 'update']);
Route::delete('/panniers/{id}',[PaniersControllers::class, 'destroy']);

// Lignes_commandes route api
// Route::resource('lignecommandes',LignesControllers::class);

Route::get('/lignecommandes',[LignesControllers::class, 'index']);
Route::get('/lignecommandes/{id}',[LignesControllers::class, 'show']);
Route::post('/lignecommandes',[LignesControllers::class, 'store']);
Route::put('/lignecommandes/{id}',[LignesControllers::class, 'update']);
Route::delete('/lignecommandes/{id}',[LignesControllers::class, 'destroy']);

