<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start([
        'cookie_lifetime' => 86400, // Tempo de vida do cookie de sessão em segundos (aqui configurado para 1 dia)
        'cookie_secure' => isset($_SERVER['HTTPS']), // Garante que os cookies sejam transmitidos apenas por HTTPS
        'cookie_httponly' => true, // Garante que os cookies não sejam acessíveis via JavaScript
    ]);
}
?>