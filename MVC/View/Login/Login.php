<?php 
include_once(__DIR__ . '/../../config.php');
include_once(__DIR__ . '/../../Controller/UserController.php');
$erros = $_SESSION['erros'] ?? [];
unset($_SESSION['erros']);

$permissao = $_SESSION['usuario']['permissao'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
                    <?php if ($permissao == 1): ?>
                        <li><a href="Usuarios">Usuários</a></li>
                    <?php endif; ?>
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
    <h1>Login</h1>

    <form method="POST" action="index.php?url=LOGAR">

        <label>Email:</label>
        <input type="text" name="email" id="email" placeholder="email@gmail.com"><br><br>

        <label>Senha:</label>
        <input type="password" name="senha" id="senha" placeholder="Digite sua senha"><br><br>

        <button type="submit" name="logar">Entrar</button>

        <?php 
        // Exibir mensagens de erro
        if (!empty($erros)) {
            foreach ($erros as $error) {
                echo "<div class='error'>$error</div>";
            }
        }
        ?>
    </form>
</body>
</html>