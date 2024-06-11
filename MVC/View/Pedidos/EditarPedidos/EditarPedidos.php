<?php 
include_once(__DIR__ . '/../../../config.php');

if (!isset($_SESSION['usuario'])) {
    header('Location: Login');
    exit();
}
include_once(__DIR__ . '/../../../Controller/PedidosController.php');
$pedidoController = new PedidosController();
if (isset($_SESSION['usuario']) && isset($_SESSION['usuario']['permissao'])) {
    $permissao = $_SESSION['usuario']['permissao'];
} else {
    $permissao = null;
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    
    $id = $_GET['id'];
    $pedido = $pedidoController->buscarPedido($id);
    
    // Agora você pode usar $id para buscar o pedido no banco de dados
} else {
    echo "ID do pedido inválido na URL!";
}

$erros = $_SESSION['erros'] ?? [];
unset($_SESSION['erros']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/../../PROJETOFINALPHP/MVC/Assets/css/styles.css">
    <title>Editar Pedido</title>
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
    <h1>Editar Pedido</h1>

    <form method="POST" action="index.php?url=AtualizarPedido">
        <label for="pedido_id">Pedido ID :<?php print $pedido['pedido_id']?></label>
        <input type="hidden" name="pedido_id" id="pedido_id" value="<?php print $pedido['pedido_id'] ?>"><br><br>

        <label>Descrição do Produto:</label>
        <input type="text" name="descricao" id="descricao" value="<?php print $pedido['descricao'] ?>" maxlength="200"><br><br>

        <label>Quantidade:</label>
        <input type="number" name="qntd" id="qntd" value="<?php print $pedido['qntd'] ?>"><br><br>

        <label>Peso:</label>
        <input type="text" name="peso-kg" id="peso-kg" value="<?php print $pedido['peso-kg'] ?>" maxlength="8"><br><br>

        <label>Data de Recebimento:</label>
        <input type="text" name="recebimento" id="recebimento" value="<?php print date('d/m/Y', strtotime($pedido['recebimento'])) ?>" maxlength="10"><br><br>

        <label>Situacao:</label>
        <select name="situacao" value="<?php print $pedido['situacao'] ?>">
            <option value="0" <?= $pedido['situacao'] == 0 ? 'selected' : '' ?>>Pendente</option>
            <option value="1" <?= $pedido['situacao'] == 1 ? 'selected' : '' ?>>Entregue</option>
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
