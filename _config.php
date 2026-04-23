
<?php 

$conn = new mysqli("HOSTNAME", "USERNAME", "PASSWORD", "DATABASE"); //just like $conn = new mysqli("localhost", "root", "", "anipaca");


if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error);
    echo("Database connection failed.");
}


$websiteTitle = "Ani Verse";
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$websiteUrl = "{$protocol}://{$_SERVER['SERVER_NAME']}";
$websiteLogo = $websiteUrl . "/public/logo/logo.png";
$contactEmail = "contact@aniverse.com";

$version = "1.1.0";

$discord = "https://discord.gg/aniverse";
$github = "https://github.com/aniverse";
$telegram = "https://t.me/aniverse";
$instagram = "https://www.instagram.com/aniverse"; 

// all the api you need
$zpi = "https://anime-api-ashen-chi.vercel.app/api"; 
$proxy = ""; // Removed proxy as requested

//If you want faster loading speed just put // before the first proxy and remove slashes from this one 
//$proxy = "https://your-hosted-proxy.com/proxy?url=";


$banner = $websiteUrl . "/public/images/banner.png";


    