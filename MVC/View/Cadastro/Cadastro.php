<?php 
include_once(__DIR__ . '/../../config.php');
include_once(__DIR__ . '/../../Controller/UserController.php');
$erros = $_SESSION['erros'] ?? [];
unset($_SESSION['erros']);
if (isset($_SESSION['usuario']) && isset($_SESSION['usuario']['permissao'])) {
    $permissao = $_SESSION['usuario']['permissao'];
} else {
    $permissao = null;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="/MVC/Assets/css/styles.css">
</head>

<script>
    function mascaraCPF() {
        var cpf = document.getElementById('cpf');
        if (cpf.value.length == 3 || cpf.value.length == 7) 
        {
            cpf.value += ".";
        } else if (cpf.value.length == 11) {
            cpf.value += "-";
        }
    }
</script>

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
    <h1>Cadastrar</h1>

    <form method="POST" action="index.php?url=cadastrarUsuario">

        <label>Nome:</label>
        <input type="text" name="nomeUsuario" id="nomeUsuario" placeholder="Nome completo"><br><br>

        <label>Email:</label>
        <input type="text" name="email" id="email" placeholder="email@gmail.com"><br><br>

        <label>CPF:</label>
        <input type="text" name="cpf" id="cpf" placeholder="12345678910" maxlength="14" onkeyup="mascaraCPF()"><br><br>

        <label>Data de Nascimento:</label>
        <input type="text" name="dataNascimento" id="dataNascimento" placeholder="DD/MM/AAAA" maxlength="10"><br><br>

        <label>Senha:</label>
        <input type="password" name="senha" id="senha" placeholder="Digite sua senha"><br><br>

        <label>Confirme sua senha:</label>
        <input type="password" name="confSenha" id="confSenha" placeholder="Confirme sua senha"><br><br>

        <button type="submit" name="cadastrarUsu">Cadastrar</button>

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
