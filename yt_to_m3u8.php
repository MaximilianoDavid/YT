<?php

function obtener_m3u8($url)
{
    $comando = "yt-dlp -f best --get-url " . escapeshellarg($url);
    $output = shell_exec($comando);

    if ($output) {
        return trim($output);
    } else {
        return null;
    }
}

// Verifica si el parámetro 'url' está presente en la URL
if (isset($_GET['url'])) {
    $video_url = $_GET['url'];

    // Validar que la URL sea correcta
    if (!filter_var($video_url, FILTER_VALIDATE_URL)) {
        die("URL no válida.");
    }

    // Obtener la URL directa del stream
    $m3u8_url = obtener_m3u8($video_url);

    if ($m3u8_url) {
        // Configurar encabezados para forzar la descarga
        header("Content-Type: application/vnd.apple.mpegurl");
        header("Content-Disposition: attachment; filename=stream.m3u8");
        echo $m3u8_url;
    } else {
        echo "Error al obtener el archivo .m3u8.";
    }
} else {
    echo "Por favor, proporciona una URL de video en el parámetro 'url'.";
}

?>