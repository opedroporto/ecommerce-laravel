<?php

use \Carbon\Carbon;

use Illuminate\Support\Facades\Http;

use App\Models\Endereco;

function mask($val, $mask)
{
    $masked = '';
    $k = 0;
    for($i = 0; $i<=strlen($mask)-1; $i++)
    {
    if($mask[$i] == '#')
    {
        if(isset($val[$k]))
        $masked .= $val[$k++];
    }
    else
    {
        if(isset($mask[$i]))
        $masked .= $mask[$i];
        }
    }
    return $masked;
}

function format_endereco($endereco) {
    $end_complemento = $endereco->complemento ? ", " . $endereco->complemento : "";
    $end_cep = format_cep($endereco->cep);
    return  "Rua {$endereco->rua}{$end_complemento}, {$endereco->bairro}, {$endereco->cidade}, {$endereco->uf}, {$end_cep}";
}

function format_cep($cep) {
    // $cep = str_replace("-", "$cep);
    $cep = preg_replace("/[^0-9]/", '', $cep);
    return mask($cep, '#####-###');
}

function getShippingTax($data) {
    // origem
    $endereco = Endereco::whereId(1)->get()->first();
    $origem_end = urlencode(format_endereco($endereco));
    
    // destino
    $endereco = Endereco::whereId($data['id_end'])->get()->first();
    $destino_end = urlencode(format_endereco($endereco));
    
    // call api
    $uri = "https://maps.googleapis.com/maps/api/distancematrix/json?destinations=" . $destino_end . "&origins=" . $origem_end . "&key=" . env('GOOGLE_MAPS_API_KEY');
    $response_row = Http::get($uri)['rows'];

    try {
        $distance = $response_row[0]['elements'][0]['distance']['value'];
        $duration = $response_row[0]['elements'][0]['duration']['value'];

        // calculate shipping tax
        $distance_km = $distance / 1000;
        $shipping_tax = $distance_km * 5;

        // return $shipping_tax;
        session()->put("shipping_tax" . $data['secret_token'], $shipping_tax);
        session()->save();
        return session()->get("shipping_tax" . $data['secret_token']);

        // return "R$ " . number_format($shipping_tax, 2, ",", ".");
    } catch (\Exception $e) {
        // default fallback shipping tax
        $shipping_tax = 50;

        // return $shipping_tax;
        session()->put("shipping_tax" . $data['secret_token'], $shipping_tax);
        session()->save();
        return session()->get("shipping_tax" . $data['secret_token']);

    }
}

function getWithdrawalDate($data) {
    $date = Carbon::now()->addDays(3)->format("Y-m-d");
    return $date;
    
    session()->put("min_withdrawal_date" . $data['secret_token'], $date);
    session()->save();

    return session()->get("min_withdrawal_date" . $data['secret_token']);
    // return $date;
}

function getShippingDate($data) {
    $date = Carbon::now()->addDays(7)->format("Y-m-d");
    return $date;

    session()->put("shipping_date" . $data['secret_token'], $date);
    session()->save();

    return session()->get("shipping_date" . $data['secret_token']);
    // return $date;
}

function usuarioRole($role) {
    switch ($role) {
        case 0:
            return "Usuário";
            break;
        case 1:
            return "Administrador";
            break;
        default:
            return "Indefinido";
            break;
    }
}

function translateStatus($status) {
    switch ($status) {
        case "open":
            return "Aguardando pagamento";
            break;
        case "complete":
            return "Finalizado";
            break;
        case "expired":
            return "Expirado";
            break;
        default:
            return "Indefinido";
            break;
    }
}