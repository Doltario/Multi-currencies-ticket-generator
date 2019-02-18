<?php

    require_once __DIR__ . "/vendor/autoload.php";

    use CurrencyConverter\CurrencyService;
    use CurrencyConverter\Price;
    use CurrencyConverter\Article;
    use CurrencyConverter\Basket;
    // refresh composer.json for autoload:     'composer dumpautoload -o'

    $currencyService = CurrencyService::init();
    $currencyService->setOutputCurrency("USD");

    $passion = new Article("Fruit de la passion", "150€");
    $banane = new Article("Banane", "140¥");


    $basket = new Basket();

    $basket->addToBasket($passion, 1); // $basket->addToBasket($passion); also works
    $basket->addToBasket($passion, 2);
    $basket->addToBasket($banane, 1); // $basket->addToBasket($article1); also works

    $basket->printTicket();

