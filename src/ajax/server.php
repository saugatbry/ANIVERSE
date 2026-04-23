<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
require_once($_SERVER['DOCUMENT_ROOT'] . '/_config.php');

$animeId = $_GET['animeId'] ?? null;
$episodeNumber = isset($_GET['episode']) ? (int)$_GET['episode'] : 1;
$season = isset($_GET['season']) ? (int)$_GET['season'] : 1;

if (!$animeId) {
    echo json_encode(['success' => false, 'error' => 'Missing animeId']);
    exit;
}

$apiUrl = sprintf('%s/stream?id=%s&season=%d&ep=%d', $zpi, urlencode($animeId), $season, $episodeNumber);
$response = @file_get_contents($apiUrl);

if ($response === false) {
    echo json_encode(['success' => false, 'error' => 'Unable to fetch stream options', 'api_url' => $apiUrl]);
    exit;
}

$data = json_decode($response, true);
if (!$data || empty($data['success'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid API response', 'api_url' => $apiUrl]);
    exit;
}

$options = $data['results'] ?? [];
$servers = [];
foreach ($options as $idx => $opt) {
    $servers[] = [
        'serverName' => 'Server ' . ($idx + 1),
        'serverId' => 'options-' . $idx,
    ];
}

// API is not split by dub/sub; mirror servers to both tabs for compatibility.
echo json_encode([
    'success' => true,
    'sub' => $servers,
    'dub' => $servers,
]);
