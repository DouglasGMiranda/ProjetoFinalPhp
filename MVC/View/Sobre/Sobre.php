<?php 

$permissao = $_SESSION['usuario']['permissao']; 

?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
</body>
</html>