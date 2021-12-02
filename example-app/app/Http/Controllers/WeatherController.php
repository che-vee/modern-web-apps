<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Services\WeatherForcastService;

class WeatherController extends Controller
{
    public function getWeather()
    {
        $weatherForcast = new WeatherForcastService;
        $data = $weatherForcast->getWeather();

        return view('weather', ["data"=>$data]);
    }
}
