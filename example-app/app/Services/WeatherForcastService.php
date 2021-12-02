<?php

namespace App\Services;

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
$dotenv->load();

class WeatherForcastService
{
    public function getWeather()
    {

        $httpClient = new \GuzzleHttp\Client();
        $apiKey = $_ENV['API_KEY'];
        $lat = -4.6796;
        $lon = 55.4920;
        $request =
            $httpClient
                ->get("https://api.openweathermap.org/data/2.5/onecall?lat={$lat}&lon={$lon}&exclude=current,minutely,hourly,alerts&appid={$apiKey}&units=metric");

        $response = json_decode($request->getBody()->getContents(), true);

        return $response;
    }
}