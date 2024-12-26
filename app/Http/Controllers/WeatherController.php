<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Forecast;

class WeatherController extends Controller
{
    public function getWeather(Request $request)
    {
        $apiKey = env('WEATHERSTACK_API_KEY');
        $cidade = $request->input('cid');
        $cidade = explode(',', $cidade)[0];

        $api = "http://api.weatherstack.com/current?access_key=" . $apiKey . "&query=" . urlencode($cidade);

        $response = Http::get($api);

        if ($response->successful()) {
            $data = $response->json();

            // Verifica se há erro na resposta da API
            if (isset($data['error'])) {
                return back()->withErrors(['message' => 'Erro na API: ' . $data['error']['info']]);
            }

            // Mapeamento dos códigos para os simplificados
            $mapping = [
                395 => 227, 392 => 227, 377 => 227, 374 => 227, 338 => 227, 335 => 227, 332 => 227, // Neve
                359 => 176, 356 => 176, 353 => 176, 176 => 176,                                     // Chuva Leve
                200 => 200, 386 => 200, 389 => 200,                                                 // Tempestade
                119 => 119, 122 => 119,                                                             // Nublado
                116 => 116,                                                                         // Parcialmente Nublado
                113 => 113,                                                                         // Ensolarado
            ];

            $weatherIcons = [
                113 => 'sunny.png',         // Ensolarado
                116 => 'partly-cloudy.png', // Parcialmente Nublado
                119 => 'cloudy.png',        // Nublado
                176 => 'rainy.png',         // Chuva Leve
                200 => 'storm.png',         // Tempestade
                227 => 'snow.png',          // Neve
            ];

            $weatherDescriptions = [
                113 => 'Ensolarado',
                116 => 'Parcialmente Nublado',
                119 => 'Nublado',
                176 => 'Chuva Leve',
                200 => 'Tempestade',
                227 => 'Neve',
            ];

            // Obtém o código da API e aplica o mapeamento
            $apiCode = $data['current']['weather_code'] ?? null;
            $simplifiedCode = $mapping[$apiCode] ?? null;

            $icon = $simplifiedCode ? asset('images/weather/' . ($weatherIcons[$simplifiedCode] ?? 'default.png')) : asset('images/weather/default.png');
            $description = $simplifiedCode ? ($weatherDescriptions[$simplifiedCode] ?? 'Desconhecido') : 'Desconhecido';

            // Retorna os dados para a view
            return view('index', [
                'weather' => $data,
                'icon' => $icon,
                'description' => $description,
            ]);
        }

        // Caso a API falhe
        return back()->withErrors(['message' => 'Não foi possível obter os dados da previsão do tempo. Tente novamente.']);
    }

    public function save(Request $request){
        
        $validated = $request->validate([
            'location_name' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'temperature' => 'required|numeric',
            'description' => 'required|string|max:255',
            'wind_speed' => 'required|numeric',
            'pressure' => 'required|numeric',
            'humidity' => 'required|numeric',
            'visibility' => 'required|numeric',
            'uv_index' => 'required|numeric',
            'feelslike' => 'required|numeric',
        ]);

        Forecast::create($validated);

        return redirect()->back()->with('success', 'Previsão salva com sucesso!');
    }

    public function clima(Request $request){
        $weather = [
            "request" => [
                "type" => "City",
                "query" => "Chapeco, Brazil",
                "language" => "en",
                "unit" => "m"
            ],
            "location" => [
                "name" => "Chapeco",
                "country" => "Brazil",
                "region" => "Santa Catarina",
                "lat" => "-27.083",
                "lon" => "-52.983",
                "timezone_id" => "America/Sao_Paulo",
                "localtime" => "2024-12-18 15:55",
                "localtime_epoch" => 1734537300,
                "utc_offset" => "-3.0"
            ],
            "current" => [
                "observation_time" => "06:55 PM",
                "temperature" => 31,
                "weather_code" => 113,
                "weather_icons" => [
                    "https://cdn.worldweatheronline.com/images/wsymbols01_png_64/wsymbol_0001_sunny.png"
                ],
                "weather_descriptions" => ["Sunny"],
                "wind_speed" => 9,
                "wind_degree" => 19,
                "wind_dir" => "NNE",
                "pressure" => 1010,
                "precip" => 0,
                "humidity" => 35,
                "cloudcover" => 7,
                "feelslike" => 31,
                "uv_index" => 9,
                "visibility" => 10,
                "is_day" => "yes"
            ]
        ];

        $weatherIcons = [
            113 => 'sunny.png',         // "Ensolarado"
            116 => 'partly-cloudy.png', // "Parcialmente Nublado"
            119 => 'cloudy.png',        // "Nublado"
            176 => 'rainy.png',         // "Chuva Leve"
            200 => 'storm.png',         // "Tempestade"
            227 => 'snow.png',          // "Neve"
        ];

        $weatherDescription = [
            113 => 'Ensolarado',         
            116 => 'Parcialmente Nublado', 
            119 => 'Nublado',       
            176 => 'Chuva Leve',        
            200 => 'Tempestade',
            227 => 'Neve',          
        ];

        $currentWeatherCode = $weather['current']['weather_code'];
        
        $icon = isset($weatherIcons[$currentWeatherCode]) ? asset('images/weather/'.$weatherIcons[$currentWeatherCode]) : asset('images/weather/default.png');

        $description = isset($weatherDescription[$currentWeatherCode]) ? $weatherDescription[$currentWeatherCode] : 'Desconhecido';

        return view('index', ['weather' => $weather, 'icon' => $icon, 'description' => $description]);

    }
}
