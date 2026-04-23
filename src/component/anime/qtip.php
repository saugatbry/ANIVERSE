<?php

function fetchAnimeData($animeId) {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/_config.php');
    global $zpi;

    $url = "$zpi/info?id=" . urlencode($animeId);
    $animeDataResponse = @file_get_contents($url);
    if ($animeDataResponse === false) {
        return false;
    }

    $animeResponse = json_decode($animeDataResponse, true);
    if (!$animeResponse || empty($animeResponse['success'])) {
        return false;
    }

    // Supports both old and new API response shapes
    $data = $animeResponse['results']['data'] ?? $animeResponse['data'] ?? $animeResponse['results'] ?? [];
    $animeInfo = $data['animeInfo'] ?? [];
    $tvInfo = $animeInfo['tvInfo'] ?? [];

    $title = $data['title'] ?? 'Unknown';
    $genres = $animeInfo['Genres'] ?? $data['genres'] ?? [];
    if (!is_array($genres)) $genres = [];

    return [
        'poster' => $data['poster'] ?? 'default_poster.jpg',
        'id' => $data['id'] ?? $data['anime_id'] ?? $animeId,
        'malId' => $data['malId'] ?? null,
        'anilistId' => $data['anilistId'] ?? null,
        'title' => $title,
        'japanese' => $data['jname'] ?? $title,
        'overview' => $animeInfo['Overview'] ?? $data['overview'] ?? 'No description',
        'showType' => $tvInfo['showType'] ?? ($data['type'] ?? 'TV'),
        'rating' => $tvInfo['rating'] ?? ($data['rating'] ?? 'N/A'),
        'subEp' => $tvInfo['sub'] ?? $tvInfo['eps'] ?? ($data['episodes'] ?? 0),
        'dubEp' => $tvInfo['dub'] ?? 0,
        'status' => $animeInfo['Status'] ?? 'Unknown',
        'genres' => $genres,
        'quality' => $tvInfo['quality'] ?? ($data['quality'] ?? 'HD'),
        'duration' => $tvInfo['duration'] ?? ($data['runningTime'] ?? $animeInfo['Duration'] ?? 'Unknown'),
        'actors' => [],
        'studio' => $animeInfo['Studios'] ?? null,
        'producer' => $animeInfo['Producers'] ?? [],
        'season' => [],
        'relatedAnimes' => [],
        'recommendedAnimes' => [],
        'adultContent' => $data['adultContent'] ?? false,
    ];
}
