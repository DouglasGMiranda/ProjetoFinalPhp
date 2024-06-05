<?php 
include_once(__DIR__ . '/../../../config.php');

if (!isset($_SESSION['usuario'])) {
    header('Location: Login');
    exit();
}
include_once(__DIR__ . '/../../../Controller/PedidosController.php');
$pedidoController = new PedidosController();
$id = $_GET['id'];
$pedido = $pedidoController->buscarPedido($id);
$erros = $_SESSION['erros'] ?? [];
unset($_SESSION['erros']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pedido</title>
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
    <h1>Editar Pedido</h1>

    <form method="POST" action="index.php?url=AtualizarPedido">
        <input type="hidden" name="pedido_id" value="<?= $pedido['pedido_id'] ?>">

        <label>Descrição do Produto:</label>
        <input type="text" name="descricaoProduto" id="descricaoProduto" value="<?= $pedido['descricaoProduto'] ?>" maxlength="200"><br><br>

        <label>Quantidade:</label>
        <input type="number" name="quantidade" id="quantidade" value="<?= $pedido['quantidade'] ?>"><br><br>

        <label>Peso:</label>
        <input type="text" name="peso" id="peso" value="<?= $pedido['peso'] ?>" maxlength="8"><br><br>

        <label>Data de Recebimento:</label>
        <input type="text" name="dataRecebimento" id="dataRecebimento" value="<?= date('d/m/Y', strtotime($pedido['dataRecebimento'])) ?>" maxlength="10"><br><br>

        <label>Status:</label>
        <select name="status">
            <option value="0" <?= $pedido['status'] == 0 ? 'selected' : '' ?>>Pendente</option>
            <option value="1" <?= $pedido['status'] == 1 ? 'selected' : '' ?>>Entregue</option>
        </select><br><br>

        <button type="submit" name="atualizarPedido">Atualizar</button>

        <?php 
        if (!empty($erros)) {
            foreach ($erros as $error) {
                echo "<div class='error'>$error</div>";
            }
        }
        ?>
    </form>
</body>
</html>