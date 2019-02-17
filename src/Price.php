<?php


namespace CurrencyConverter;

use CurrencyConverter\CurrencyService;

class Price {
    private $currencyService;
    private $rawValue;
    public $currency;
    public $value;

    public function __construct($rawValue) {
        $this->currencyService = CurrencyService::init();
        $this->rawValue = $rawValue;

        $this->currency = $this->currencyService->determineCurrency($this->rawValue);

        $this->value = $this->currencyService->substringSymbol($this->rawValue, $this->currency);
        // echo "----" . $this->currency . " " . $this->value . "----";
    }

    public function getComputedValue() {
        return $this->value . $this->currencyService->getSymbol($this->currency);
    }
}