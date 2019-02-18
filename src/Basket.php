<?php

namespace CurrencyConverter;

use CurrencyConverter\Price;
use CurrencyConverter\Article;
use CurrencyConverter\CurrencyService;

class Basket {
    static $currencyService;
    private $articlesList = [];
    private $ticketRow = "|%5.5s |%-30.30s | %s \n";
    private $ticketFooter = "%38s | %s \n";
    public  $total;

    public function __construct() {
        self::$currencyService = CurrencyService::init();
        $this->total = new Price("0" . self::$currencyService->defaultOutputSymbol);
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
        return self::$currencyService->multiply($articleToPrint['value']->price, $articleToPrint['quantity']);
    }

    public function printRow($articleToPrint, $subTotal, $lineWidth = 25) {        
        printf($this->ticketRow, $articleToPrint['quantity'], $articleToPrint['value']->name, $subTotal->getComputedValue());
    }

    public function printTicket() {

        printf($this->ticketRow, "Qte", "Nom", "Sous-total");

        foreach ($this->articlesList as $articleToPrint) {
            $subTotal = $this->getSubTotal($articleToPrint);
            $this->printRow($articleToPrint, $subTotal);
            $this->total = self::$currencyService->add($this->total, $subTotal);
        }  

        printf($this->ticketFooter, "Total", $this->total->getComputedValue());
    }
}
