<?php

    require_once __DIR__ . "/vendor/autoload.php";

    use CurrencyConverter\Price;
    // refresh composer.json for autoload:     'composer dumpautoload -o'


    $prix1 = new Price("199€");

    // var_dump($prix1);