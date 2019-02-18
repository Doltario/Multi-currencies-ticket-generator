<?php


namespace CurrencyConverter;

use CurrencyConverter\CurrencyService;

class Price {
    static $currencyService;
    private $rawValue;
    public $currency;
    public $value;

    public function __construct($rawValue) {
        self::$currencyService = CurrencyService::init();
        $this->rawValue = $rawValue;
        
        $this->currency = self::$currencyService->determineCurrency($this->rawValue);
        
        $this->value = self::$currencyService->substringSymbol($this->rawValue, $this->currency);
    }

    public function getComputedValue() {
        return $this->value . self::$currencyService->getSymbol($this->currency);
    }
}