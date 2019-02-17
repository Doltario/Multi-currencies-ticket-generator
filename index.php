<?php

    require_once __DIR__ . "/vendor/autoload.php";

    use CurrencyConverter\Price;
    use CurrencyConverter\CurrencyService;
    // refresh composer.json for autoload:     'composer dumpautoload -o'

    $currencyService = CurrencyService::init();
    $currencyService->setOutputCurrency("EUR");

    $prix1 = new Price("199€");

    $prix2 = new Price("200$");

    // var_dump($prix1);
    // var_dump($currencyService);

    echo $currencyService->add($prix1, $prix2);
