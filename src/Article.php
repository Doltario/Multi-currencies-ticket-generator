<?php

namespace CurrencyConverter;

use CurrencyConverter\Price;

class Article {
    public $name;
    public $price;

    public function __construct($name, $price) {
        $this->name = $name;
        $this->price = new Price($price);
    }

}
