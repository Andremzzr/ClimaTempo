<?php

require_once __DIR__.'/vendor/autoload.php';

use App\Weather;


$weather = new Weather;

$weather_result = [];

$weather_result = $weather->getWeatherByCity('Esteio');

print_r($weather_result);