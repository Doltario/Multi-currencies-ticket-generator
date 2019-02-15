<?php


namespace CurrencyConverter;



class CurrencyService {
    private static $_instance;
    public static $currencies = [
        'EUR' => ['value' => 'EUR', 'symbol' => '€'],
        'USD' => ['value' => 'USD', 'symbol' => '$'],
        'YEN' => ['value' => 'YEN', 'symbol' => '¥']
    ];

    private function __construct() {
        // echo 'Should never be used, use create() instead';
    }

    public static function init() {
        if (is_null(self::$_instance)){
            self::$_instance = new CurrencyService();
        }
        return self::$_instance;
    }

    public function determineCurrency($string) {
        $trimmedString = trim($string);
        foreach (self::$currencies as $currency) {
            if (strpos($trimmedString, $currency['symbol']) !== false) {
                return $currency['value'];
            }
        }
       
        throw new \Exception('Cannot resolve currency in "' . $trimmedString . '"');
    }

    public function substringSymbol($string, $currency) {
        if (!self::$currencies[$currency]) {
            throw new \Exception('Currency '. $currency . ' not recognized');
        }

        $trimmedString = trim($string);
        if (strpos($trimmedString, self::$currencies[$currency]['symbol']) !== false) {
            return substr($trimmedString, 0, strpos($trimmedString, self::$currencies[$currency]['symbol']));
        }

        throw new \Exception('No ' . $currency . 'symbol found in "' . $trimmedString . '"');
    }

    public static function add($prix1, $prix2) {

    }
}
