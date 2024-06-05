<?php 
include_once(__DIR__ . '/../../../config.php');

if (!isset($_SESSION['usuario'])) {
    header('Location: Login');
    exit();
}
include_once(__DIR__ . '/../../../Controller/PedidosController.php');
$erros = $_SESSION['erros'] ?? [];
unset($_SESSION['erros']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Pedidos</title>
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
    <h1>Cadastrar Pedidos</h1>

    <form method="POST" action="index.php?url=CadastrarPedidos">
        <label>Descrição do Produto:</label>
        <input type="text" name="descricaoProduto" id="descricaoProduto" placeholder="Descrição do produto" maxlength="200"><br><br>

        <label>Quantidade:</label>
        <input type="text" name="quantidade" id="quantidade" placeholder="Quantidade"><br><br>

        <label>Peso:</label>
        <input type="text" name="peso" id="peso" placeholder="Peso(0,00kg)" maxlength="8"><br><br>

        <label>Data de Recebimento:</label>
        <input type="text" name="dataRecebimento" id="dataRecebimento" placeholder="DD/MM/AAAA" maxlength="10"><br><br>

        <button type="submit" name="cadastrarPedidos">Cadastrar</button>

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
