<?php 
$url = strtoupper($_GET['url'] ?? '');

if ($url == 'CADASTRO') {
    require_once(__DIR__ . '/View/Cadastro.php');
} elseif ($url == 'CADASTRARUSUARIO') {
    require_once(__DIR__ . '/Controller/UserController.php');
    $usuarioController = new UsuarioController();
    $usuarioController->processa('C');
} else {
    echo "Página não encontrada!";
}
?>
