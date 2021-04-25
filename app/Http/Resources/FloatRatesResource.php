<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class FloatRatesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "url"                =>     $this["link"],
            "rate"               =>     $this["title"],
            "description"        =>     $this["description"],
            "updated"            =>     Carbon::parse($this["pubDate"]),
            "baseCurrency"       =>     $this["baseCurrency"],
            "baseName"           =>     $this["baseName"],
            "targetCurrency"     =>     $this["targetCurrency"],
            "targetName"         =>     $this["targetName"],
            "exchangeRate"       =>     $this["exchangeRate"],
            "inverseRate"        =>     $this["inverseRate"],
            "inverseDescription" =>     $this["inverseDescription"],
        ];
    }
}
