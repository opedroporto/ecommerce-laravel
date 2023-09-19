<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Usuario;
use App\Models\Pedido;

class AdminController extends Controller
{
    public function index() {
        $quantidade_usuarios = Usuario::where("role", 0)->get()->count();
        $quantidade_admins = Usuario::where("role", 1)->get()->count();
        $quantidade_pedidos_mes = Pedido::whereMonth('created_at', '=', '09')->get()->count();
        $faturamento_mes = Pedido::whereMonth('created_at', '=', '09')->where("pago", true)->sum('valor');
        $faturamento_total = Pedido::where("pago", true)->sum('valor');

        return view("admin.index", compact("quantidade_usuarios", "quantidade_admins", "quantidade_pedidos_mes", "faturamento_mes", "faturamento_total"));
    }
}
