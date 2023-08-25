<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Admin
Route::group([
    "prefix" => "admin",
    "as" => "admin."
], function() {
    Route::get("/", function() {
        return view("admin.index");
    })->name("index");
});

// Site
Route::group([
    "prefix" => "",
    "as" => "site."
], function() {
    Route::get("/", [Controllers\SiteController::class, "index"])->name("index");
    Route::get("/produto/{id}/{slug}", [Controllers\ProdutoController::class, "show"])->name("verproduto");

    Route::get("/carrinho", [Controllers\CarrinhoController::class, "lista"])->name("carrinho");
    Route::post("/carrinho", [Controllers\CarrinhoController::class, "add"])->name("addcarrinho");
    Route::get("/finalizarcompra", [Controllers\CarrinhoController::class, "proceedToCheckout"])->name("finalizarcompra")->middleware("authuser");
    
    Route::post("/addpedido", [Controllers\PedidoController::class, "store"])->name("addpedido")->middleware("authuser");
    Route::get("/pedidos", [Controllers\PedidoController::class, "index"])->name("getpedidos")->middleware("authuser");

    Route::post("/finalizarpedido", [Controllers\StripeController::class, "checkout"])->name("checkout");
    Route::get("/sucesso", [Controllers\StripeController::class, "success"])->name("success");
});

// Login
Route::group([
    "prefix" => "",
    "as" => "login."
], function() {
    Route::post("/login", [Controllers\LoginController::class, "login"])->name("login"); 
    Route::get("/logout", [Controllers\LoginController::class, "logout"])->name("logout"); 
    Route::post("/cadastro", [Controllers\LoginController::class, "signup"])->name("signup"); 
});

// API
Route::group([
    "prefix" => "",
    "as" => "api."
], function() {
    Route::post("/dataentrega", [Controllers\ApiController::class, "getShippingDate"])->name("getshippingdate");
    Route::post("/dataretirada", [Controllers\ApiController::class, "getWithdrawalDate"])->name("getwithdrawaldate");
});