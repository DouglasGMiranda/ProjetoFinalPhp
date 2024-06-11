<?php 
include_once(__DIR__ . '/../../../config.php');
if (isset($_SESSION['usuario']) && isset($_SESSION['usuario']['permissao'])) {
    $permissao = $_SESSION['usuario']['permissao'];
} else {
    $permissao = null;
}

if ($permissao == 0) {
    header('Location: Home');
    exit();
}

else{
    include_once(__DIR__ .'/../../../Controller/UserController.php');
    $usuarioController = new UsuarioController();

    if (isset($_GET['id']) && !empty($_GET['id'])) {
    
        $id = $_GET['id'];
        $usuario = $usuarioController->buscarUsuario($id);
        
        // Agora você pode usar $id para buscar o pedido no banco de dados
    } else {
        echo "ID do pedido inválido na URL!";
    }

    
    $erros = $_SESSION['erros'] ?? [];
    unset($_SESSION['erros']);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/../../PROJETOFINALPHP/MVC/Assets/css/styles.css">
    <title>Editar Usuario</title>
</head>
<script>
    function mascaraCPF() {
    var cpf = document.getElementById('cpf');
    if (cpf.value.length == 3 || cpf.value.length == 7) {
        cpf.value += ".";
    } else if (cpf.value.length == 11) {
        cpf.value += "-";
    }
}
</script>
<body>
    <header>
        <div class="cabecalho">
            <div class="logo">D&G</div>
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
    <h1>Editar Usuario</h1>

    <form method="POST" action="index.php?url=AtualizarUsuario">
        <label for="user_id">User ID: <?php print $usuario['user_id']?></label>
        <input type="hidden" name="user_id" value="<?php print $usuario['user_id']?>"><br><br>

        <label for="nome">Nome:</label>
        <input type="text" name="nomeUsuario" id="nomeUsuario" value="<?php print $usuario['nomeUsuario']?>"><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php print $usuario['email']?>"><br><br>

        <label for="cpf">CPF:</label>
        <input type="text" name="cpf" id="cpf" maxlength="14" onkeyup="mascaraCPF()" value="<?php print $usuario['cpf']?>"><br><br>

        <label for="dataNascimento">Data de Nascimento:</label>
        <input type="text" name="dataNascimento" id="dataNascimento" value="<?php print date('d/m/Y', strtotime($usuario['dataNascimento'])) ?>" maxlength="10"><br><br>

        <label for="senha">Senha:</label>
        <input type="text" name="senha" id="senha" value="<?php print $usuario['senha']?>"><br><br>

        <label for="confSenha">Confirme a senha:</label>
        <input type="text" name="confSenha" id="confSenha" value="<?php print $usuario['senha']?>"><br><br>

        <label for="permissao">Permissão: </label>
        <input type="number" name="permissao" id="permissao" value="<?php print $usuario['permissao']?>"><br><br>

        <input type="submit" value="Atualizar">

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