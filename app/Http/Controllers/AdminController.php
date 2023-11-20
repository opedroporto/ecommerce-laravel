<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Categoria;
use App\Models\Usuario;
use App\Models\Pedido;
use App\Models\Produto;

class AdminController extends Controller
{
    public function index() {
        $quantidade_usuarios = Usuario::where("role", 0)->get()->count();
        $quantidade_admins = Usuario::where("role", 1)->get()->count();
        $quantidade_pedidos_pendentes_mes = Pedido::whereMonth('created_at', '=', date('m'))->where('status', 'open')->get()->count();
        $quantidade_pedidos_pagos_mes = Pedido::whereMonth('created_at', '=', date('m'))->where('status', 'complete')->get()->count();
        $faturamento_total = Pedido::where('status', 'complete')->sum('valor');
        $faturamento_mes = Pedido::whereMonth('created_at', '=', date('m'))->where('status', 'complete')->sum('valor');

        // Gráfico: produtos
        $usuariosData = Usuario::select([
            DB::raw("YEAR(created_at) as ano"),
            DB::raw("COUNT(*) as total")
        ])
        ->groupBy("ano")
        ->orderBy("ano", "asc")
        ->get();
        foreach($usuariosData as $usuario) {
            $ano[] = $usuario->ano;
            $total[] = $usuario->total;
        }
        $usuariosAno = implode(",", $ano);
        $usuariosTotal = implode(",", $total);

        // Gráfico: categorias
        $categoriasData = Categoria::all();
        foreach($categoriasData as $categoria) {
            $categoriasNome[] = "'" . Str::limit($categoria->nome, 30) . "'";
            $categoriasTotal[] = Produto::where("id_categoria", $categoria->id)->count();
        }
        $categoriasLabel = implode(",", $categoriasNome);
        $categoriasTotal = implode(",", $categoriasTotal);
        $categoriasQnt = count($categoriasData);

        return view("admin.index", compact("quantidade_usuarios", "quantidade_admins", "quantidade_pedidos_pendentes_mes", "quantidade_pedidos_pagos_mes", "faturamento_total", "faturamento_mes", "faturamento_total", "usuariosAno", "usuariosTotal", "categoriasLabel", "categoriasTotal", "categoriasQnt"));
    }
}
