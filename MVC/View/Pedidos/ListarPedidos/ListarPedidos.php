<?php 
include_once(__DIR__ . '/../../../config.php');

if (!isset($_SESSION['usuario'])) {
    header('Location: Login');
    exit();
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
    <title>Lista de Pedidos</title>
    <?php 
    print_r(($_SESSION['usuario']));
    
    
    ?>
</head>
<body>
    <header>
        <div class="cabecalho">
            <div class="logo">A nossa logo</div>
            <nav>
                <ul>
                    <li><a href="Home">Home</a></li>
                    <li><a href="ListarPedidos">Lista de Pedidos</a></li>
                    <li><a href="CadastroPedido">Cadastro de Pedidos</a></li>
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
    <h1>Lista de Pedidos</h1>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Descrição</th>
                <th>Quantidade</th>
                <th>Peso</th>
                <th>Data de Recebimento</th>
                <th>Data de Entrega</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $pedido): ?>
                <tr>
                    <td><?= $pedido['$pedido_id'] ?></td>
                    <td><?= $pedido['descricaoProduto'] ?></td>
                    <td><?= $pedido['quantidade'] ?></td>
                    <td><?= $pedido['peso'] ?></td>
                    <td><?= date('d/m/Y', strtotime($pedido['dataRecebimento'])) ?></td>
                    <td><?= date('d/m/Y', strtotime($pedido['dataEntrega'])) ?></td>
                    <td><?= $pedido['status'] ? 'Entregue' : 'Pendente' ?></td>
                    <td>
                        <a href="EditarPedido?id=<?= $pedido['$pedido_id'] ?>">Editar</a>
                        <a href="index.php?url=Deletarpedido&id=<?= $pedido['idpedido'] ?>" onclick="return confirm('Tem certeza que deseja deletar?')">Deletar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
