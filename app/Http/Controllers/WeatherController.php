<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Importa a classe Http

class WeatherController extends Controller
{
    public function getWeather(Request $request){
        $apiKey = env('WEATHERSTACK_API_KEY');
        $cidade = $request->input('cid');
        $cidade = explode(',', $cidade);
        $cidade = $cidade[0];

        $api = "http://api.weatherstack.com/current?access_key=".$apiKey."&query=".$cidade;

        $response = Http::get($api);

        if ($response->successful()) {
            $data = $response->json(); // Converte a resposta JSON em um array associativo
    
            // Verifica se há erro na resposta da API
            if (isset($data['error'])) {
                return back()->withErrors(['message' => 'Erro na API: ' . $data['error']['info']]);
            }
            // Retorna os dados para a view
            return view('index', ['weather' => $data]);
        }
    
        // Se a requisição falhar, retorna uma mensagem de erro
        return back()->withErrors(['message' => 'Não foi possível obter os dados da previsão do tempo. Tente novamente.']);

    }

    public function store(Request $request){
        
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
