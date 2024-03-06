<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Callapi;
use App\Models\ScoreCard;

class ApiController extends Controller
{
    public $keyLive = '8b0c753ec7msh0efc9f192e80dd9p19a301jsnc2abb827a489';
    public $hostLive = 'cricbuzz-cricket.p.rapidapi.com';

    public function liveCall($key, $host, $url) {
        $headers = [
            'http' => [
                'header' => "X-RapidAPI-Key: ".$key."\r\n" .
                    "X-RapidAPI-Host: ".$host."\r\n",
            ],
        ];
        $context = stream_context_create($headers);
        $response = file_get_contents($url, false, $context);
        return $response;
    }
    public function checkInCache($cacheKey, $seconds) {
        if (Cache::has($cacheKey)) {
            $cachedData = Cache::get($cacheKey);
            $currentTime = now();
            $lastUpdateTime = $cachedData['updated_at'];
            if ($currentTime->diffInSeconds($lastUpdateTime) < $seconds)
                return $cachedData['data'];
        }
    }
    public function matchComm($matchId) {
        $cacheKey = 'api_data_' . $matchId;
        $seconds = 10;
        $response = $this->checkInCache($cacheKey, $seconds);
        if ($response) {
            return $response;
            exit;        
        }
        $url = 'https://cricbuzz-cricket.p.rapidapi.com/mcenter/v1/' . $matchId . '/comm';
        $response = $this->liveCall($this->keyLive, $this->hostLive, $url);
        Cache::put($cacheKey, ['data' => $response, 'updated_at' => now()], $seconds);
        return $response;
    }
    public function matchScoreCard($matchId) {
        $cacheKey = 'api_data_' . $matchId;
        $seconds = 10;
        $response = $this->checkInCache($cacheKey, $seconds);
        if ($response) {
            return $response;
            exit;        
        }
        $url = 'https://cricbuzz-cricket.p.rapidapi.com/mcenter/v1/' . $matchId . '/scard';
        $response = $this->liveCall($this->keyLive, $this->hostLive, $url);
        Cache::put($cacheKey, ['data' => $response, 'updated_at' => now()], $seconds);
        return $response;
    }
    public function rankings($person, $formatType) {
        $cacheKey = 'api_data_' . $person .'_'. $formatType;
        $seconds = 10;
        $response = $this->checkInCache($cacheKey, $seconds);
        if ($response) {
            return $response;
            exit;        
        }
        $url = 'https://cricbuzz-cricket.p.rapidapi.com/stats/v1/rankings/'.$person.'?formatType='.
        $formatType;
        $response = $this->liveCall($this->keyLive, $this->hostLive, $url);
        Cache::put($cacheKey, ['data' => $response, 'updated_at' => now()], $seconds);
        return $response;
    }
    public function rankingsWomen($person, $formatType) {
        $cacheKey = 'api_data_' . $person .'_'. $formatType;
        $seconds = 10;
        $response = $this->checkInCache($cacheKey, $seconds);
        if ($response) {
            return $response;
            exit;        
        }
        $url = 'https://cricbuzz-cricket.p.rapidapi.com/stats/v1/rankings/'.$person.'?formatType='.
        $formatType.'isWomn=1';
        $response = $this->liveCall($this->keyLive, $this->hostLive, $url);
        Cache::put($cacheKey, ['data' => $response, 'updated_at' => now()], $seconds);
        return $response;
    }
    public function series($seriesType) {
        $cacheKey = 'api_data_series'. $seriesType;
        $seconds = 10;
        $response = $this->checkInCache($cacheKey, $seconds);
        if ($response) {
            return $response;
            exit;        
        }
        $url = 'https://cricbuzz-cricket.p.rapidapi.com/series/v1/'.$seriesType;
        $response = $this->liveCall($this->keyLive, $this->hostLive, $url);
        Cache::put($cacheKey, ['data' => $response, 'updated_at' => now()], $seconds);
        return $response;
    }
    public function statsSeries($seriesId, $detail = '') {
        $cacheKey = $detail !== '' ? 'api_data_stats_series_'.$detail.'_'. $seriesId : 'api_data_stats_series_'. $seriesId;
        $url = $detail !== '' ? 'https://cricbuzz-cricket.p.rapidapi.com/stats/v1/series/'.$seriesId.'/'.$detail : 'https://cricbuzz-cricket.p.rapidapi.com/stats/v1/series/'.$seriesId;
        $seconds = 10;
        $response = $this->checkInCache($cacheKey, $seconds);
        if ($response) {
            return $response;
            exit;        
        }
        $response = $this->liveCall($this->keyLive, $this->hostLive, $url);
        Cache::put($cacheKey, ['data' => $response, 'updated_at' => now()], $seconds);
        return $response;
    }
    public function matches($status) {
        $cacheKey = 'api_data_matches'. $status;
        $seconds = 10;
        $response = $this->checkInCache($cacheKey, $seconds);
        if ($response) {
            return $response;
            exit;        
        }
        $url = 'https://cricbuzz-cricket.p.rapidapi.com/matches/v1/' . $status;
        $response = $this->liveCall($this->keyLive, $this->hostLive, $url);
        Cache::put($cacheKey, ['data' => $response, 'updated_at' => now()], $seconds);
        return $response;
    }
}
