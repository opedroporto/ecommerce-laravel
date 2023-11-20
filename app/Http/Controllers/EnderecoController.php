<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Endereco;

class EnderecoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // GET
        if($request->isMethod("get")){
            return redirect()->route("site.perfil");
        }
        // POST
        if($request->isMethod("post")){
            
            // validate data
            $validator = Validator::make($request->all(), [
                'rua' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->route("site.perfil")
                            ->withErrors($validator)
                            ->withInput();
            }
            
            // store new endereco
            // $endereco_data = $validator->validated();
            $endereco_data = $request->all();
            unset($endereco_data['_token']);
            $endereco_data['id_usuario'] = auth()->user()->id;

            $endereco = Endereco::create($endereco_data);

            return redirect()->route("site.perfil");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // validate data
        $validator = Validator::make($request->all(), [
            'rua' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route("site.perfil")
                        ->withErrors($validator)
                        ->withInput();
        }

        // update produto
        // $endereco_data = $validator->validated();
        $endereco_data = $request->all();
        unset($endereco_data['_token']);

        Endereco::where("id_usuario", auth()->user()->id)->whereId($endereco_data['id'])->update($endereco_data);

        return redirect()->route("site.perfil");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Endereco::where("id_usuario", auth()->user()->id)->whereId($request->id)->delete();

        return redirect()->route("site.perfil");
    }
}
