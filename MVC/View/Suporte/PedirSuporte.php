<?php
// Verifique se a sessão já foi iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Iniciar a sessão se ainda não tiver sido iniciada
}

// Inclua os arquivos necessários
include_once(__DIR__ . '/../../config.php');
include_once(__DIR__ . '/../../Controller/SuporteController.php');

$erros = $_SESSION['erros'] ?? [];
unset($_SESSION['erros']);

// Inicializar a variável de permissões
$permissao = isset($_SESSION['usuario']['permissao']) ? $_SESSION['usuario']['permissao'] : null;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suporte</title>
    <link rel="stylesheet" href="Assets/css/styles.css"> <!-- Adicione o CSS caso necessário -->
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
    <h1>Suporte</h1>

    <form method="POST" action="index.php?url=CadastrarSuporte">
        <label>CPF registrado:</label>
        <input type="text" name="cpfUser" id="cpfUser" placeholder="CPF" maxlength="11"><br><br>

        <label>Email registrado:</label>
        <input type="text" name="emailUser" id="emailUser" placeholder="Email@email.com" maxlength="120"><br><br>

        <label>Descrição do problema:</label>
        <textarea name="Descricao" id="Descricao" placeholder="Descreva o problema" maxlength="300"></textarea><br><br>

        <button type="submit" name="enviarSuporte">Enviar</button>

        <?php 
            if (!empty($erros)) {
                foreach ($erros as $error) {
                    echo "<div class='error'>$error</div>";
                }
            }
        ?>
    </form>
    <footer>
        <div class="container">
            <p>&copy; 2024 Todos os direitos reservados. D&G Logística.</p>
        </div>
    </footer>
</body>
</html>
