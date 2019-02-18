<?php

    require_once __DIR__ . "/vendor/autoload.php";

    use CurrencyConverter\CurrencyService;
    use CurrencyConverter\Price;
    use CurrencyConverter\Article;
    use CurrencyConverter\Basket;
    // refresh composer.json for autoload:     'composer dumpautoload -o'

    $currencyService = CurrencyService::init();
    $currencyService->setOutputCurrency("NOK");

    $prix1 = new Price("150€");

    $prix2 = new Price("0$");

    $passion = new Article("Fruit de la passion", "150€");
    $banane = new Article("Banane", "140¥");


    $basket = new Basket();

    $basket->addToBasket($passion, 1); // $basket->addToBasket($passion); also works
    $basket->addToBasket($passion, 2); // $basket->addToBasket($passion); also works
    $basket->addToBasket($banane, 1); // $basket->addToBasket($article1); also works

    // var_dump($prix1);
    // var_dump($currencyService);

    // var_dump($basket);
    $basket->printTicket();
    // customEcho($currencyService->add($prix1, $prix2)->getComputedValue());
