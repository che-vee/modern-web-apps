<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Services\WeatherForcastService;

class WeatherController extends Controller
{
    public function getWeather(Request $request)
    {
        $weatherForcast = new WeatherForcastService;
        $data = $weatherForcast->getWeather();

        $data = $data['daily'];

        foreach ($data as &$day) {
            $day['date'] = \Carbon\Carbon::createFromTimeStamp($day['dt'])->toDateString();
            $day['temp'] = $day['temp']['day'];

            unset($day['dt']);
        }

        $sort_by = $request->query('sortby');

        $order = 'ASC';

        $sort_by_key = $sort_by;

        if ($sort_by != null) {
            if ($sort_by[0] == '-') {
                $order = 'DESC';
                $sort_by = substr($sort_by, 1);
            }

            usort($data, function ($a, $b) use ($sort_by, $order) {

                if ($order == "DESC") {
                    return $a[$sort_by] > $b[$sort_by];
                } else {
                    return $a[$sort_by] < $b[$sort_by];
                }
            });
        }

        return view('weather', ["data" => $data, "sortby" => $sort_by_key]);
    }
}
