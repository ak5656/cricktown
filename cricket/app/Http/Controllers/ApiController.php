<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Callapi;
use App\Models\ScoreCard;

class ApiController extends Controller
{
    public $keyLive = '83a0367f5fmsh10fe7a525a45caap1b996fjsn13c24036e8d0';
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
        $cacheKey = 'api_data_comm_' . $matchId;
        $seconds = 20;
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
        $cacheKey = 'api_data_scard_' . $matchId;
        $seconds = 20;
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
    public function matchInfo($matchId) {
        $cacheKey = 'api_data_info_' . $matchId;
        $seconds = 900;
        $response = $this->checkInCache($cacheKey, $seconds);
        if ($response) {
            return $response;
            exit;        
        }
        $url = 'https://cricbuzz-cricket.p.rapidapi.com/mcenter/v1/' . $matchId;
        $response = $this->liveCall($this->keyLive, $this->hostLive, $url);
        Cache::put($cacheKey, ['data' => $response, 'updated_at' => now()], $seconds);
        return $response;
    }
    public function team($matchId, $teamId) {
        $cacheKey = 'api_data_team_' . $matchId. '_'. $teamId;
        $seconds = 900;
        $response = $this->checkInCache($cacheKey, $seconds);
        if ($response) {
            return $response;
            exit;        
        }
        $url = 'https://cricbuzz-cricket.p.rapidapi.com/mcenter/v1/' . $matchId . '/team/' . $teamId;
        $response = $this->liveCall($this->keyLive, $this->hostLive, $url);
        Cache::put($cacheKey, ['data' => $response, 'updated_at' => now()], $seconds);
        return $response;
    }
    public function rankings($person, $formatType) {
        $cacheKey = 'api_data_ranking_men_' . $person .'_'. $formatType;
        $seconds = 604800;
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
        $cacheKey = 'api_data_ranking_women' . $person .'_'. $formatType;
        $seconds = 604800;
        $response = $this->checkInCache($cacheKey, $seconds);
        if ($response) {
            return $response;
            exit;        
        }
        $url = 'https://cricbuzz-cricket.p.rapidapi.com/stats/v1/rankings/'.$person.'?formatType='.
        $formatType.'&isWomen=1';
        $response = $this->liveCall($this->keyLive, $this->hostLive, $url);
        Cache::put($cacheKey, ['data' => $response, 'updated_at' => now()], $seconds);
        return $response;
    }
    public function series($seriesType) {
        $cacheKey = 'api_data_series'. $seriesType;
        $seconds = 86400;
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
        if ($detail !== '')
            $seconds = 900;
        else
            $seconds = 86400;
        $response = $this->checkInCache($cacheKey, $seconds);
        if ($response) {
            return $response;
            exit;        
        }
        $response = $this->liveCall($this->keyLive, $this->hostLive, $url);
        Cache::put($cacheKey, ['data' => $response, 'updated_at' => now()], $seconds);
        return $response;
    }
    public function publicStatsSeries($seriesId, $statsType = '') {
        $cacheKey = $statsType !== '' ? 'api_data_public_stats_series_'.$seriesId.'_'. $statsType : 'api_data_public_stats_series_'. $seriesId;

        $url = $statsType !== '' ? 'https://cricktown.28infotech.com/cricket/public/api/stats/series/'.$seriesId.'?statsType='.$statsType : 'https://cricktown.28infotech.com/cricket/public/api/stats/series/'.$seriesId;

        $seconds = 900;
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
        if ($status === 'live')
            $seconds = 60;
        else
            $seconds = 900;
        
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
    public function statsPlayer($id, $info = '') { //echo 'hlllo'; die;
        $cacheKey = $info !== '' ? 'api_data_stats_player_'.$id.'_'. $info : 'api_data_stats_player_'. $id;
        $seconds = 86400;
        $response = $this->checkInCache($cacheKey, $seconds);
        if ($response) {
            return $response;
            exit;        
        }
        $url = $info !== '' ? 'https://cricbuzz-cricket.p.rapidapi.com/stats/v1/player/'.$id.'/'.$info : 'https://cricbuzz-cricket.p.rapidapi.com/stats/v1/player/'.$id;
        $response = $this->liveCall($this->keyLive, $this->hostLive, $url);
        Cache::put($cacheKey, ['data' => $response, 'updated_at' => now()], $seconds);
        return $response;
    }
}
