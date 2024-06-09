<?php 
include_once(__DIR__ . '/config.php');
$url = strtoupper($_GET['url'] ?? '');

if ($url == 'CADASTRO') {
    require_once(__DIR__ . '/View/Cadastro/Cadastro.php');
} 
elseif ($url == 'CADASTRARUSUARIO') {
    require_once(__DIR__ . '/Controller/UserController.php');
    $usuarioController = new UsuarioController();
    $usuarioController->validaUser();
}
elseif ($url == 'HOME' || $url == '') {
    require_once(__DIR__ . '/View/Home/Home.php');
}
elseif($url == 'SOBRE'){
    require_once(__DIR__ . '/View/Sobre/Sobre.php');
}
elseif ($url == 'LOGIN') {
    require_once(__DIR__ . '/View/Login/Login.php');
}
elseif ($url == 'LOGAR') {
    require_once(__DIR__ . '/Controller/UserController.php');
    $usuarioController = new UsuarioController();
    $usuarioController->logar();
}
elseif ($url == 'LOGOUT') {
    require_once(__DIR__ . '/Controller/UserController.php');
    $usuarioController = new UsuarioController();
    $usuarioController->logout();
}

elseif ($url == 'CADASTROPEDIDO') {
    if (!isset($_SESSION['usuario'])) {
        header('Location: Login');
        exit();
    }
    require_once(__DIR__ . '/View/Pedidos/CadastroPedidos/CadastroPedidos.php');
} 
elseif ($url == 'CADASTRARPEDIDOS') {
    require_once(__DIR__ . '/Controller/PedidosController.php');
    $PedidosController = new PedidosController();
    $PedidosController->cadastrarPedidos();
}
elseif ($url == 'LISTARPEDIDOS') {
    if (!isset($_SESSION['usuario'])) {
        header('Location: Login');
        exit();
    }
    require_once(__DIR__ . '/View/Pedidos/ListarPedidos/ListarPedidos.php');
}
elseif ($url == 'EDITARPEDIDOS') {
    if (!isset($_SESSION['usuario'])) {
        header('Location: Login');
        exit();
    }
    elseif(isset($_GET['id'])) {
        // Obtém o valor da variável
        $id = $_GET['id'];
        require_once(__DIR__ . '/View/Pedidos/EditarPedidos/EditarPedidos.php');
    }
}
elseif ($url == 'ATUALIZARPEDIDOS') {
    require_once(__DIR__ . '/Controller/PedidosController.php');
    $PedidosController = new PedidosController();
    $PedidosController->atualizarPedido();
}
elseif ($url == 'DELETARPEDIDOS') {
    require_once(__DIR__ . '/Controller/PedidosController.php');
    $PedidosController = new PedidosController();
    $PedidosController->deletarPedido($_GET['id']);
}
else {
    echo "Página não encontrada!";
}
?>
