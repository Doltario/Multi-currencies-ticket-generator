<?php


namespace CurrencyConverter;

use CurrencyConverter\CurrencyService;

class Price {
    private $currencyService;
    private $rawValue;
    public $currency;
    public $value;

    public function __construct($rawValue) {
        $currencyService = CurrencyService::init();
        $this->rawValue = $rawValue;

        $this->currency = $currencyService->determineCurrency($this->rawValue);

        $this->value = $currencyService->substringSymbol($this->rawValue, $this->currency);
        // echo "----" . $this->currency . " " . $this->value . "----";
    }

    public function getComputedValue() {
        return $this->value . $currencyService->getSymbol($this->currency);
    }
}