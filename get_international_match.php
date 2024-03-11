<?php
date_default_timezone_set('Asia/Calcutta');
$key = '83a0367f5fmsh10fe7a525a45caap1b996fjsn13c24036e8d0';
$host = 'cricbuzz-cricket.p.rapidapi.com';
$url = 'https://cricbuzz-cricket.p.rapidapi.com/series/v1/international';




echo callService($key, $host, $url);


function callService($key, $host, $url) {
   $oldResponse = readOldResponse();
   $oldResponse = json_decode($oldResponse, true);
   $oldDate = date('Y-m-d H:i:s', strtotime($oldResponse['datetime']));
   $currentDataTIme = date('Y-m-d H:i:s');
   $isLatest = isLatestData($currentDataTIme, $oldDate);

   if ($isLatest === 'yes') {
       return json_encode($oldResponse['data']);
   } else {
       $liveMatches = getLiveMatchesData($key, $host, $url);
       putLiveMatchesData($liveMatches);
       return $liveMatches;
   }
        
}


function readOldResponse() {
    $fileData = file_get_contents("./getInternationalMatchesData.txt") or die("Unable to open file!");
    return $fileData;
}


function isLatestData($currentTime, $lastCallTime) {
    $maxOldTime = 86400; // second;
    $lastCallTime = strtotime($lastCallTime);
    $currentTime = strtotime(date('Y-m-d H:i:s'));
    $diff = round(abs($lastCallTime - $currentTime), 2);
    $status = '';
    if (intval($diff) > intval($maxOldTime))
        return $status = 'no';
    else
        return $status = 'yes';
}

function putLiveMatchesData($data)
{   $BASEPATH =  __DIR__;
    $myfile = fopen($BASEPATH . "/" .  "getInternationalMatchesData.txt", "w") or die("Unable to open file!");
    $customeResponse = json_encode(['datetime' => date('Y-m-d H:i:s'), 'data' => json_decode($data)]);
    fwrite($myfile, $customeResponse);
    fclose($myfile); 
}

function getLiveMatchesData($key = null, $host = null, $url = null) {
    $request_headers = array('X-RapidAPI-Key:' . $key, 'X-RapidAPI-Host:' . $host);
    try {
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_NOBODY, 0);
        $response = curl_exec ($ch);
        curl_close ($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);
        return $body;
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
}