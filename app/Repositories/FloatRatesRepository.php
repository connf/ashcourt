<?php

namespace App\Repositories;

use App\Http\Resources\FloatRatesResource;

class FloatRatesRepository
{
    protected $apiUrl;

    public $data;

    public function __construct()
    {
        $this->url = config('floatrate.base_url')
            .config('floatrate.route').'/'
            .config('floatrate.local_currency').'.'
            .config('floatrate.extension');
    }

    /**
     * Using a callApi method allows for better customizability and security
     * Only a private method will be allowed to make the API calls
     * Only the methods that we fully control will be publically accessible
     * eg for the routes / controllers to call the functionality from elsewhere etc
     * This prevents from different types of injection and users overriding URLs etc or passing parameters we don't want them to have access to
     */
    private function callApi()
    {
        // Get the XML from the FloatRates URL
        return simplexml_load_file($this->url);
    }

    /**
     * Return the XML as JSON
     */
    public function getRawJson()
    {
        return response()->json($this->callApi());
    }

    /**
     * This function:
     * - Accepts the call to get all the exchange data (eg Via a Controller)
     * - Gets the returned data
     * - And Processes it so we can pass the clean data back for use
     */
    private function collectData()
    {
        // Decode the API data
        $data = $this->callApi();

        // Convert the data to JSON
        // - We could return the response()->json($data) here
        // But instead I am converting to JSON to create an Array compatible with the Resource / Transformer / collections
        $json = json_encode($data);

        // And convert the JSON to an array for the Resource / Fractal Transformer
        $array = json_decode($json, true);

        // This could also be done in one line using:
        // $array = json_decode(json_encode($xml), true);
        // But it was easier as individual lines for improved commenting

        $this->data = collect(FloatRatesResource::collection($array["item"])->resolve());
    }

    public function getData()
    {
        $this->collectData();
        
        return $this->data;
    }

    /**
     * Return the JSON data for a currency symbol
     */
    public function getSymbolRateFor($symbol)
    {
        $this->collectData();

        return response()->json($this->data->where("targetCurrency", strtoupper($symbol)));
    }
}
