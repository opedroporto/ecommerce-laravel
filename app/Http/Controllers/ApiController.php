<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GetShippingDateRequest;
use App\Http\Requests\GetWithdrawalDateRequest;
use App\Http\Requests\GetShippingTaxRequest;

class ApiController extends Controller
{
    public function getShippingDate(GetShippingDateRequest $request) {
        $data = $request;

        return getShippingDate($data);
    }

    public function getWithdrawalDate(GetWithdrawalDateRequest $request) {
        $data = $request;

        return getWithdrawalDate($data);
    }

    public function getShippingTax(GetShippingTaxRequest $request) {
        // TODO: validate
        
        // $data = $request->validated();
        $data = $request;

        return getShippingTax($data);

    }
}
