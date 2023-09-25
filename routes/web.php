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

// Admin
Route::group([
    "prefix" => "controle",
    "as" => "admin.",
    "middleware" => "authadmin"
], function() {
    // index
    Route::get("/", [Controllers\AdminController::class, "index"])->name("index");

    // produto
    Route::group([
        "as" => "produtos."
    ], function() {
        Route::get("/produtos", [Controllers\AdminProdutoController::class, "index"])->name("index");
        Route::match(["get", "post"], "/produto/adicionar", [Controllers\AdminProdutoController::class, "store"])->name("add");
        Route::get("/produto/{id}", [Controllers\AdminProdutoController::class, "showFull"])->name("show");
        Route::post("/produto/deletar", [Controllers\AdminProdutoController::class, "destroy"])->name("delete");
        Route::post("/produto/deletarvarios", [Controllers\AdminProdutoController::class, "destroymany"])->name("deletemany");
        Route::post("/produto/editar", [Controllers\AdminProdutoController::class, "update"])->name("edit");
    });

    // colecoes
    Route::group([
        "as" => "colecoes."
    ], function() {
        Route::get("/colecoes", [Controllers\AdminColecaoController::class, "index"])->name("index");
        Route::match(["get", "post"], "/colecao/adicionar", [Controllers\AdminColecaoController::class, "store"])->name("add");
        Route::get("/colecao/{id}", [Controllers\AdminColecaoController::class, "showFull"])->name("show");
        Route::post("/colecao/deletar", [Controllers\AdminColecaoController::class, "destroy"])->name("delete");
        Route::post("/colecao/deletarvarios", [Controllers\AdminColecaoController::class, "destroymany"])->name("deletemany");
        Route::post("/colecao/editar", [Controllers\AdminColecaoController::class, "update"])->name("edit");
    });

    // categorias
    Route::group([
        "as" => "categorias."
    ], function() {
        Route::get("/categorias", [Controllers\AdminCategoriaController::class, "index"])->name("index");
        Route::match(["get", "post"], "/categoria/adicionar", [Controllers\AdminCategoriaController::class, "store"])->name("add");
        Route::get("/categoria/{id}", [Controllers\AdminCategoriaController::class, "showFull"])->name("show");
        Route::post("/categoria/deletar", [Controllers\AdminCategoriaController::class, "destroy"])->name("delete");
        Route::post("/categoria/deletarvarios", [Controllers\AdminCategoriaController::class, "destroymany"])->name("deletemany");
        Route::post("/categoria/editar", [Controllers\AdminCategoriaController::class, "update"])->name("edit");
    });

    // usuarios
    Route::group([
        "as" => "usuarios."
    ], function() {
        Route::get("/usuarios", [Controllers\AdminUsuarioController::class, "index"])->name("index");
        Route::match(["get", "post"], "/usuario/adicionar", [Controllers\AdminUsuarioController::class, "store"])->name("add");
        Route::get("/usuario/{id}", [Controllers\AdminUsuarioController::class, "showFull"])->name("show");
        Route::post("/usuario/deletar", [Controllers\AdminUsuarioController::class, "destroy"])->name("delete");
        Route::post("/usuario/deletarvarios", [Controllers\AdminUsuarioController::class, "destroymany"])->name("deletemany");
        Route::post("/usuario/editar", [Controllers\AdminUsuarioController::class, "update"])->name("edit");
    });

    // enderecos
    Route::group([
        "as" => "enderecos."
    ], function() {
        Route::get("/enderecos", [Controllers\AdminEnderecoController::class, "index"])->name("index");
        Route::match(["get", "post"], "/endereco/adicionar", [Controllers\AdminEnderecoController::class, "store"])->name("add");
        Route::get("/endereco/{id}", [Controllers\AdminEnderecoController::class, "showFull"])->name("show");
        Route::post("/endereco/deletar", [Controllers\AdminEnderecoController::class, "destroy"])->name("delete");
        Route::post("/endereco/deletarvarios", [Controllers\AdminEnderecoController::class, "destroymany"])->name("deletemany");
        Route::post("/endereco/editar", [Controllers\AdminEnderecoController::class, "update"])->name("edit");
    });

    // pedidos
    Route::group([
        "as" => "pedidos."
    ], function() {
        Route::get("/pedidos", [Controllers\AdminPedidoController::class, "index"])->name("index");
        Route::match(["get", "post"], "/pedido/adicionar", [Controllers\AdminPedidoController::class, "store"])->name("add");
        Route::get("/pedido/{id}", [Controllers\AdminPedidoController::class, "showFull"])->name("show");
        Route::post("/pedido/deletar", [Controllers\AdminPedidoController::class, "destroy"])->name("delete");
        Route::post("/pedido/deletarvarios", [Controllers\AdminPedidoController::class, "destroymany"])->name("deletemany");
        Route::post("/pedido/editar", [Controllers\AdminPedidoController::class, "update"])->name("edit");
    });
});