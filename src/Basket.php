<?php

namespace CurrencyConverter;

use CurrencyConverter\Price;
use CurrencyConverter\Article;

class Basket {
    private $articlesList = [];

    public function __construct() {
    }

    public function addTobasket(Article $articleToAdd, $quantity = 1) {

        foreach ($this->articlesList as $key => $value) {
            if ($this->articlesList[$key]["value"] == $articleToAdd){
                $this->articlesList[$key]['quantity'] += $quantity;
                return;
            }
        }

        $this->articlesList[] = [
            "value" => $articleToAdd,
            "quantity" => $quantity
        ];
        return $this;
    }
}
