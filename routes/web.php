<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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
    // Route::get("/test", [Controllers\PaymentController::class, "test"])->name("test");
    // Route::get("/setwebhook", [Controllers\PaymentController::class, "setWebhook"])->name("setwebhook");
    // Route::get("/seewebhook", [Controllers\PaymentController::class, "seeWebhook"])->name("seewebhook");
    // Route::get("/seecharges", [Controllers\PaymentController::class, "seeCharges"])->name("seechages");

    // index
    Route::get("/", [Controllers\SiteController::class, "index"])->name("index");

    // sobre
    Route::get("/sobre", [Controllers\SiteController::class, "sobre"])->name("sobre");

    // perfil
    Route::get("/perfil", [Controllers\SiteController::class, "perfil"])->name("perfil")->middleware("authuser");
    Route::post("/editarusuario", [Controllers\UsuarioController::class, "update"])->name("editusuario")->middleware("authuser");
    Route::post("/addendereco", [Controllers\EnderecoController::class, "store"])->name("addendereco")->middleware("authuser");
    Route::post("/editendereco", [Controllers\EnderecoController::class, "update"])->name("editendereco")->middleware("authuser");
    Route::post("/deleteendereco", [Controllers\EnderecoController::class, "destroy"])->name("deleteendereco")->middleware("authuser");

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
    
    Route::get("/pedidos", [Controllers\PedidoController::class, "index"])->name("getpedidos")->middleware("authuser");
    Route::post("/addpedido", [Controllers\PedidoController::class, "store"])->name("addpedido")->middleware("authuser");
    Route::get("/finalizarpedido", [Controllers\PaymentController::class, "checkout"])->name("checkout")->middleware("authuser");
    
    Route::get("/sucesso", [Controllers\PaymentController::class, "success"])->name("success");
});

// Login
Route::group([
    "prefix" => "",
    "as" => "login.",
], function() {
    Route::post("/login", [Controllers\LoginController::class, "login"])->middleware("guest")->name("login"); 
    Route::get("/logout", [Controllers\LoginController::class, "logout"])->name("logout"); 
    Route::post("/cadastro", [Controllers\LoginController::class, "signup"])->middleware("guest")->name("signup"); 

    // PASSWORD

    // GET: reset 1
    Route::get('/resetarsenha', [Controllers\PasswordController::class, "reset1"])->middleware("guest")->name('resetarsenha');

    // POST: reset 1
    Route::post('/resetarsenha', [Controllers\PasswordController::class, "reset2"])->middleware("guest")->name('resetarsenha2');

    // GET: reset 2
    Route::get('/resetarsenha/{token}', [Controllers\PasswordController::class, "reset3"])->middleware("guest")->name('resetarsenha3');

    // POST: reset 2
    Route::post('/modificarsenha', [Controllers\PasswordController::class, "reset4"])->middleware("guest")->name('resetarsenha4');

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
    // Route::get("/", [Controllers\PaymentController::class, "webhookResponse"])->name("webhookresponse");
    Route::post("/", [Controllers\PaymentController::class, "webhookStripe"])->name("receiveStripe"); // stripe
    Route::post("/pix", [Controllers\PaymentController::class, "webhookGn"])->name("receiveGn"); // gn
});

// Admin
Route::group([
    "prefix" => "controle",
    "as" => "admin.",
    "middleware" => "authadmin",
    // "domain" => 'controle.' . env('APP_URL')
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