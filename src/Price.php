<?php


namespace CurrencyConverter;

use CurrencyConverter\CurrencyService;

class Price {
    private $rawValue;
    private $currency;
    private $device;
    
    public function __construct($rawValue) {
        $this->currencyService = CurrencyService::init();
        $this->rawValue = $rawValue;

        $this->currency = $this->currencyService->determineCurrency($this->rawValue);

        $this->value = $this->currencyService->substringSymbol($this->rawValue, $this->currency);
        // echo "----" . $this->currency . " " . $this->value . "----";
    }
}