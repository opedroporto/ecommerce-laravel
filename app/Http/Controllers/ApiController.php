<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Carbon\Carbon;

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
}
