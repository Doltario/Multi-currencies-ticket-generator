<?php

namespace CurrencyConverter;

use CurrencyConverter\Price;
use CurrencyConverter\Article;
use CurrencyConverter\CurrencyService;

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
    
    public function getSubTotal($articleToPrint) {
        $currencyService = CurrencyService::init();
        return $currencyService->multiply($articleToPrint['value']->price, $articleToPrint['quantity']);
    }

    public function printRow($articleToPrint, $subTotal, $lineWidth = 25) {
        $row = $articleToPrint['quantity'] . " x " . $articleToPrint['value']->name . " " . $subTotal->getComputedValue();
        customEcho($row);
    }

    public function printTicket() {
        $currencyService = CurrencyService::init();
        $total = new Price("0" . $currencyService->defaultOutputSymbol);
        foreach ($this->articlesList as $articleToPrint) {
            $subTotal = $this->getSubTotal($articleToPrint);
            $this->printRow($articleToPrint, $subTotal);            
            $total = $currencyService->add($total, $subTotal);
        }  
        customEcho("-------------------------");
        customEcho($total->getComputedValue());
    }
}
