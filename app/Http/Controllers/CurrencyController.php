<?php

namespace App\Http\Controllers;

use App\Repositories\FloatRatesRepository;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new FloatRatesRepository;
    }

    public function getAllRates()
    {
        $data = $this->repository->getData();

        return respose()->json($data);
    }

    public function getJsonRates()
    {
        return $this->repository->getRawJson();
    }

    public function getRateBySymbol(string $symbol)
    {
        return $this->repository->getSymbolRateFor(strtoupper($symbol));
    }

    public function getAmericanDollars()
    {
        return $this->getRateBySymbol("USD");
    }

    public function getAustralianDollars()
    {
        return $this->getRateBySymbol("AUD");
    }
}
