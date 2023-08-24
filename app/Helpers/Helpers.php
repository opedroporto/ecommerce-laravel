<?php

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
    $end_cep = mask($endereco->cep, '#####-###');
    return  "Rua {$endereco->rua}{$end_complemento}, {$endereco->bairro}, {$endereco->cidade}, {$endereco->uf}, {$end_cep}";
}

function format_cep($cep) {

}
