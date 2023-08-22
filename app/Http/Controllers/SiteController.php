<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models;

class SiteController extends Controller
{
    public function index() {

        $produtos = Models\Produto::all();

        return view("site.index", compact("produtos"));
    }
}
