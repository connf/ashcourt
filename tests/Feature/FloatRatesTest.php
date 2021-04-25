<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FloatRatesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_can_load_index()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_can_load_raw_json()
    {
        $response = $this->get('/rates/json');

        $response->assertStatus(200);

        $expectedRecords = 149;

        // Ensure we have all expected rates
        $this->assertEquals(count($response["item"]), $expectedRecords); 
        
        // Check 2 random rates have names etc
        $this->assertArrayHasKey("baseName", $response["item"][5]);
        $this->assertArrayHasKey("baseName", $response["item"][125]);
        
        $maxRecordsKey = $expectedRecords - 1;

        // Test a random elements have all the right keys
        // Raw Json is the data directly from the website
        // - It has NOT been run through the Resource / Transformer for mapped array keys
        // - So we need to use link / pubDate instead of URL / Updated
        $this->assertArrayHasKey("link", $response["item"][rand(0, $maxRecordsKey)]);
        $this->assertArrayHasKey("title", $response["item"][rand(0, $maxRecordsKey)]);
        $this->assertArrayHasKey("description", $response["item"][rand(0, $maxRecordsKey)]);
        $this->assertArrayHasKey("pubDate", $response["item"][rand(0, $maxRecordsKey)]);
        $this->assertArrayHasKey("baseCurrency", $response["item"][rand(0, $maxRecordsKey)]);
        $this->assertArrayHasKey("baseName", $response["item"][rand(0, $maxRecordsKey)]);
        $this->assertArrayHasKey("targetCurrency", $response["item"][rand(0, $maxRecordsKey)]);
        $this->assertArrayHasKey("targetName", $response["item"][rand(0, $maxRecordsKey)]);
        $this->assertArrayHasKey("exchangeRate", $response["item"][rand(0, $maxRecordsKey)]);
        $this->assertArrayHasKey("inverseRate", $response["item"][rand(0, $maxRecordsKey)]);
        $this->assertArrayHasKey("inverseDescription", $response["item"][rand(0, $maxRecordsKey)]);
    }

    public function test_can_get_australian_dollars()
    {
        $response = $this->get('/currency/australian-dollars');

        $response->assertStatus(200);

        // Ensure we have all 11 elements
        $this->assertCount(11, json_decode($response->getContent(), true)); 
        
        // Check 2 random rates have names etc
        $this->assertArrayHasKey("url", $response);
        $this->assertArrayHasKey("rate", $response);
        $this->assertArrayHasKey("description", $response);
        $this->assertArrayHasKey("updated", $response);
        $this->assertArrayHasKey("baseCurrency", $response);
        $this->assertArrayHasKey("baseName", $response);
        $this->assertArrayHasKey("targetCurrency", $response);
        $this->assertArrayHasKey("targetName", $response);
        $this->assertArrayHasKey("exchangeRate", $response);
        $this->assertArrayHasKey("inverseRate", $response);
        $this->assertArrayHasKey("inverseDescription", $response);

        
        $this->assertSame("GBP", $response["baseCurrency"]);
        $this->assertSame("U.K. Pound Sterling", $response["baseName"]);
        $this->assertSame("AUD", $response["targetCurrency"]);
        $this->assertSame("Australian Dollar", $response["targetName"]);

        $this->assertSame("http://www.floatrates.com/gbp/aud/", $response["url"]);
        $this->assertTrue(Carbon::parse($response["updated"])->isToday());
    }
}
