<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/_config.php');

header('X-Frame-Options: SAMEORIGIN');
header("Content-Security-Policy: frame-ancestors 'self';");

$animeId = $_GET['id'] ?? '';
$server = $_GET['server'] ?? 'options-0';
$episode = isset($_GET['ep']) ? (int)$_GET['ep'] : 1;
$season = isset($_GET['season']) ? (int)$_GET['season'] : 1;

if ($animeId === '') {
    echo 'Missing anime id';
    exit;
}

$apiUrl = sprintf('%s/stream?id=%s&season=%d&ep=%d', $zpi, urlencode($animeId), $season, $episode);
$response = @file_get_contents($apiUrl);
$data = $response ? json_decode($response, true) : null;
$options = $data['results'] ?? [];

$index = 0;
if (preg_match('/options-(\d+)/', $server, $m)) {
    $index = (int)$m[1];
}

$embedUrl = $options[$index]['embed'] ?? ($options[0]['embed'] ?? null);

if (!$embedUrl) {
    echo '<div style="padding:20px;color:#fff;background:#111;height:100vh">No stream available for this episode.</div>';
    exit;
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"></head>
<body style="margin:0;background:#000;">
<iframe src="<?= htmlspecialchars($embedUrl, ENT_QUOTES) ?>" style="border:0;width:100vw;height:100vh;" allowfullscreen allow="autoplay; fullscreen; picture-in-picture"></iframe>
</body></html>
