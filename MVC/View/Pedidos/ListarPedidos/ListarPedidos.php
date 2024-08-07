<?php 
include_once(__DIR__ . '/../../../config.php');

if (!isset($_SESSION['usuario'])) {
    header('Location: Login');
    exit();
}

if (isset($_SESSION['usuario']) && isset($_SESSION['usuario']['permissao'])) {
    $permissao = $_SESSION['usuario']['permissao'];
} else {
    $permissao = null;
} 

include_once(__DIR__ . '/../../../Controller/PedidosController.php');
$PedidosController = new PedidosController();
$pedidos = $PedidosController->listarPedido();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/../../PROJETOFINALPHP/MVC/Assets/css/styles.css">
    <title>Lista de Pedidos</title>

</head>
<body>
    <header>
        <div class="cabecalho">
            <div class="logo">D&G</div>
            <nav>
                <ul>
                    <li><a href="Home">Home</a></li>
                    <li><a href="Sobre">Sobre</a></li>
                    <li><a href="ListarPedidos">Lista de Pedidos</a></li>
                    <li><a href="CadastroPedido">Cadastro de Pedidos</a></li>
                    <?php if ($permissao == 1): ?>
                        <li><a href="Usuarios">Usuários</a></li>
                    <?php endif; ?>
                    <li><a href="Suporte">Suporte</a></li>
                    <?php if (isset($_SESSION['usuario'])): ?>
                        <li><a href="index.php?url=LOGOUT">Logout</a></li>
                    <?php else: ?>
                        <li><a href="Login">Login</a></li>
                        <li><a href="Cadastro">Cadastro</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <h1 class="Listas">Lista de Pedidos</h1>
<div class="container">
    <div class="child">
        <table border="1" class="centered-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descrição</th>
                    <th>Quantidade</th>
                    <th>Peso</th>
                    <th>Data de Recebimento</th>
                    <th>Data de Entrega</th>
                    <th>Status</th>
                    <?php if ($permissao == '1'): ?>
                        <th>Ações</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $pedido): ?>
                    <tr>
                        <td><?= $pedido['pedido_id'] ?></td>
                        <td><?= $pedido['descricao'] ?></td>
                        <td><?= $pedido['qntd'] ?></td>
                        <td><?= $pedido['peso-kg'] ?></td>
                        <td><?= date('d/m/Y', strtotime($pedido['recebimento'])) ?></td>
                        <td><?= date('d/m/Y', strtotime($pedido['entrega-limite'])) ?></td>
                        <td><?= $pedido['situacao'] ? 'Entregue' : 'Pendente' ?></td>
                        
                        <?php if ($permissao == '1'): ?>
                            <td>
                                <button class="editar" onclick="location.href='EditarPedido&id=<?= $pedido['pedido_id'] ?>';">Editar</button>
                                <button class="excluir" onclick="if(confirm('Tem certeza que deseja deletar?')) { location.href='DeletarPedido&id=<?= $pedido['pedido_id'] ?>'; }">Excluir</button>
                            </td>
                        <?php endif; ?>     
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        </div>
    </div>
    <footer>
        <div class="container">
            <p>&copy; 2024 Todos os direitos reservados. D&G Logística.</p>
        </div>
    </footer>
</body>
</html>