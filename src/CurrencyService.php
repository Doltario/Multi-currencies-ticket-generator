<?php

namespace CurrencyConverter;

use CurrencyConverter\Price;

class CurrencyService {
    private static $_instance;
    private $outputCurrency;
    private $currenciesRates;
    public static $currencies = [
        'EUR' => ['value' => 'EUR', 'symbol' => '€'],
        'USD' => ['value' => 'USD', 'symbol' => '$'],
        'CNY' => ['value' => 'CNY', 'symbol' => '¥'],
        'CAD' => ['value' => 'CAD', 'symbol' => '$CAD'],
        'NOK' => ['value' => 'NOK', 'symbol' => 'Krone']
    ];

    private function __construct() {
        $this->setOutputCurrency("EUR"); // SET DEFAULT OUTPUT
    }

    public static function init() {
        if (is_null(self::$_instance)){
            self::$_instance = new CurrencyService();
        }
        return self::$_instance;
    }

    public function setOutputCurrency($outputCurrency) {
        $this->outputCurrency = $outputCurrency;
        $this->defaultOutputSymbol = $this->getSymbol($outputCurrency);
        $this->currenciesRates = $this->getCurrenciesRates($this->outputCurrency);
    }

    private function getCurrenciesRates($currency) {
        try {
            $data = file_get_contents("https://api.exchangeratesapi.io/latest?base=" . $currency);
            $data = json_decode($data, true);
            $data['rates'][$currency] = 1;
            return $data['rates'];
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function determineCurrency($string) {
        $trimmedString = trim($string);
        foreach (self::$currencies as $currency) {
            if (strpos($trimmedString, $currency['symbol']) !== false) {
                return $currency['value'];
            }
        }
        return $this->outputCurrency; // Or perhaps throw new \Exception('Cannot resolve currency in "' . $trimmedString . '"');
    }

    public function substringSymbol($string, $currency) {
        if (!self::$currencies[$currency]) {
            throw new \Exception('Currency '. $currency . ' not recognized');
        }

        $trimmedString = trim($string);
        if (strpos($trimmedString, self::$currencies[$currency]['symbol']) !== false) {
            return substr($trimmedString, 0, strpos($trimmedString, self::$currencies[$currency]['symbol']));
        }

        throw new \Exception('No ' . $currency . ' symbol found in "' . $trimmedString . '"');
    }

    public function getSymbol($currency) {
        return self::$currencies[$currency]['symbol'];
        
    }

    public function add(Price $price1, Price $price2, $outputCurrency = NULL) {
        if (is_null($outputCurrency)) {
            $outputCurrency = $this->outputCurrency;
            $currenciesRates = $this->currenciesRates;
        } else {
            $currenciesRates = $this->getCurrenciesRates($outputCurrency);
        }

        $priceInOutputCurrency1 = $price1->value * (1/$currenciesRates[$price1->currency]);
        $priceInOutputCurrency2 = $price2->value * (1/$currenciesRates[$price2->currency]);

        return new Price(round($priceInOutputCurrency1 + $priceInOutputCurrency2, 2) . $this->getSymbol($outputCurrency));
    }

    public function multiply(Price $price, $multiplier) {
        return new Price(round($price->value*$multiplier, 2) . $this->getSymbol($price->currency));
    }
}
