<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Callapi;
use App\Models\ScoreCard;

class ApiController extends Controller
{
    public function matchComm($matchId)
    {
        $cacheKey = 'api_data_' . $matchId;
        // Check if data exists in cache
        if (Cache::has($cacheKey)) {
            // Return cached data if not older than 10 seconds
            $cachedData = Cache::get($cacheKey);
            $currentTime = now();
            // $abc = json_decode($cachedData, true);
            $lastUpdateTime = $cachedData['updated_at'];
            if ($currentTime->diffInSeconds($lastUpdateTime) < 10) {
                return $cachedData['data'];
            }
        }

        $url = 'https://cricbuzz-cricket.p.rapidapi.com/mcenter/v1/' . $matchId . '/comm';

        $headers = [
            'http' => [
                'header' => "X-RapidAPI-Key: 155c725f29mshdd298cb332b3ddep1b2900jsnfabae51bda73\r\n" .
                    "X-RapidAPI-Host: cricbuzz-cricket.p.rapidapi.com\r\n",
            ],
        ];

        $context = stream_context_create($headers);

        // Use the file_get_contents to make the API call
        $response = file_get_contents($url, false, $context);

        // Decode the response
        $data = json_decode($response, true);

        // Store data in the database
        // Callapi::updateOrCreate(['match_id' => $matchId],
        // [
        //     'match_id' => $matchId,
        //     'api_name' => 'demo',
        //     'called' => 'test',
        //     'json' => json_encode($data),
        // ]);

        // Cache the data for 10 seconds
        Cache::put($cacheKey, ['data' => $response, 'updated_at' => now()], 10);

        return $response;
    }
    public function matchScoreCard($matchId)
    {
        $cacheKey = 'api_data_' . $matchId;
        // Check if data exists in cache
        if (Cache::has($cacheKey)) {
            // Return cached data if not older than 10 seconds
            $cachedData = Cache::get($cacheKey);
            $currentTime = now();
            // $abc = json_decode($cachedData, true);
            $lastUpdateTime = $cachedData['updated_at'];
            if ($currentTime->diffInSeconds($lastUpdateTime) < 10) {
                return $cachedData['data'];
            }
        }

        $url = 'https://cricbuzz-cricket.p.rapidapi.com/mcenter/v1/' . $matchId . '/scard';

        $headers = [
            'http' => [
                'header' => "X-RapidAPI-Key: 155c725f29mshdd298cb332b3ddep1b2900jsnfabae51bda73\r\n" .
                    "X-RapidAPI-Host: cricbuzz-cricket.p.rapidapi.com\r\n",
            ],
        ];

        $context = stream_context_create($headers);

        // Use the file_get_contents to make the API call
        $response = file_get_contents($url, false, $context);

        // Decode the response
        $data = json_decode($response, true);

        // Store data in the database
        // ScoreCard::updateOrCreate(['match_id' => $matchId],
        // [
        //     'match_id' => $matchId,
        //     'api_name' => 'demo',
        //     'called' => 'test',
        //     'json' => json_encode($data),
        // ]);

        // Cache the data for 10 seconds
        Cache::put($cacheKey, ['data' => $data, 'updated_at' => now()], 10);

        return $data;
    }

}
