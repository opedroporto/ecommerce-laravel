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
// Route::group([
//     "prefix" => "controle",
//     "as" => "admin.",
//     "middleware" => "authadmin"
// ], function() {
//     // index
//     Route::get("/", [Controllers\AdminController::class, "index"])->name("index");

//     // produto
//     Route::group([
//         "as" => "produtos."
//     ], function() {
//         Route::get("/produtos", [Controllers\ProdutoController::class, "index"])->name("index");
//         Route::match(["get", "post"], "/produto/adicionar", [Controllers\ProdutoController::class, "store"])->name("add");
//         Route::get("/produto/{id}", [Controllers\ProdutoController::class, "showFull"])->name("show");
//         Route::post("/produto/deletar", [Controllers\ProdutoController::class, "destroy"])->name("delete");
//         Route::post("/produto/deletarvarios", [Controllers\ProdutoController::class, "destroymany"])->name("deletemany");
//         Route::post("/produto/editar", [Controllers\ProdutoController::class, "update"])->name("edit");
//     });
// });

// Site
Route::group([
    "prefix" => "",
    "as" => "site."
], function() {
    // index
    Route::get("/", [Controllers\SiteController::class, "index"])->name("index");

    // produto
    Route::get("/produto/{id}/{slug}", [Controllers\ProdutoController::class, "show"])->name("verproduto");

    // colecao
    Route::get("/colecao/{id}/{slug}", [Controllers\ColecaoController::class, "show"])->name("vercolecao");

    // carrinho
    Route::get("/carrinho", [Controllers\CarrinhoController::class, "lista"])->name("carrinho");
    Route::post("/carrinho", [Controllers\CarrinhoController::class, "add"])->name("addcarrinho");
    Route::post("/editaritem", [Controllers\CarrinhoController::class, "edit"])->name("edititem");
    Route::post("/deletaritem", [Controllers\CarrinhoController::class, "delete"])->name("deleteitem");

    Route::get("/finalizarcompra", [Controllers\CarrinhoController::class, "proceedToCheckout"])->name("finalizarcompra")->middleware("authuser");
    
    Route::post("/addpedido", [Controllers\PedidoController::class, "store"])->name("addpedido")->middleware("authuser");
    Route::get("/pedidos", [Controllers\PedidoController::class, "index"])->name("getpedidos")->middleware("authuser");
    Route::get("/finalizarpedido", [Controllers\StripeController::class, "checkout"])->name("checkout")->middleware("authuser");
    
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
    Route::post("/frete", [Controllers\ApiController::class, "getShippingTax"])->name("getshippingtax");
});

// Webhook
Route::group([
    "prefix" => "webhook",
    "as" => "webhook."
], function() {
    Route::match(["get", "post"], "/", [Controllers\StripeController::class, "webhook"])->name("receive");
});