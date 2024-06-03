<?php 
$url = strtoupper($_GET['url'] ?? '');

if ($url == 'CADASTRO') {
    require_once(__DIR__ . '/View/Cadastro/Cadastro.php');
} 
elseif ($url == 'CADASTRARUSUARIO') {
    require_once(__DIR__ . '/Controller/UserController.php');
    $usuarioController = new UsuarioController();
    $usuarioController->validaUser();
} 
else {
    echo "Página não encontrada!";
}
?>
