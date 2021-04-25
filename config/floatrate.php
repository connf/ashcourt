<?php

return [
    "base_url" => env("FLOATRATE_BASE_URL", "http://www.floatrates.com"),
    "route" => env("FLOATRATE_ROUTE", "/daily"),
    "local_currency" => env("FLOATRATE_LOCAL_CURRENCY", "gbp"),
    "extension" => "xml"
];