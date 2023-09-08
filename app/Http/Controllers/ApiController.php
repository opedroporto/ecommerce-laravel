<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use \Carbon\Carbon;
use App\Http\Requests\GetShippingTaxRequest;
use App\Models\Endereco;

class ApiController extends Controller
{
    public function getShippingDate() {
        $date = Carbon::now()->addDays(7)->format("Y-m-d");

        session()->put("shipping_date", $date);

        return $date;
    }

    public function getWithdrawalDate() {
        $date = Carbon::now()->addDays(3)->format("Y-m-d");

        session()->put("min_withdrawal_date", $date);

        return $date;
    }

    public function getShippingTax(GetShippingTaxRequest $request) {
        // TODO: validate

        // $data = $request->validated();
        $data = $request;

        $id_end = $data['id_end'];

        $endereco = Endereco::whereId($id_end)->get()->first();
        $destino_cep = $endereco->cep;

        
        // return $response->json();
        // $json_response = $response->json();

        // return $json_response['resourceSets'][0]['resources'][0]['travelDistance'];


        $shipping_tax = 10.50;

        return number_format($shipping_tax, 2, ",", ".");
    }
}
