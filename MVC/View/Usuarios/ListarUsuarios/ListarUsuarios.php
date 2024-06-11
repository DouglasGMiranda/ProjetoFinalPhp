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

if ($permissao != 1) {
    print"script>alert('Você não tem permissão para acessar essa página!');</script>";
    print"script>location.href='Home';</script>";
    header('Location: Home');
    exit();
}

include_once(__DIR__ . '/../../../Controller/UserController.php');
$userController = new UsuarioController();
$usuario = $userController->listarUsuarios();

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/../../PROJETOFINALPHP/MVC/Assets/css/styles.css">
    <title>Lista de Usuarios</title>
</head>
<body class="listar">
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
    <h1 class="Listas">Lista de Usuarios</h1>
<div class="container">
    <div class="child">
    <table border="1" class="centered-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>CPF</th>
                <th>Data de Nascimento</th>
                <th>Senha</th>
                <th>Permissão</th>
                <th>Ações</th>
            </tr>
        </thead>
    </div>
        <tbody>
            <?php foreach($usuario as $usuarios): ?>
                <tr>
                    <td><?= $usuarios['user_id'] ?></td>
                    <td><?= $usuarios['nomeUsuario'] ?></td>
                    <td><?= $usuarios['email'] ?></td>
                    <td><?= $usuarios['cpf'] ?></td>
                    <td><?= $usuarios['dataNascimento'] ?></td>
                    <td><?= $usuarios['senha'] ?></td>
                    <td><?= $usuarios['permissao'] ?></td>
                    <td>
                        <button class="editar" onclick="location.href='EditarUsuario&id=<?= $usuarios['user_id'] ?>';"> Editar</button>
                        <button class="excluir" onclick="if(confirm('Tem certeza que deseja deletar?')) { location.href='DeletarUsuario&id=<?= $usuarios['user_id'] ?>'; }">Excluir</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
    <footer>
        <div class="container">
            <p>&copy; 2024 Todos os direitos reservados. D&G Logística.</p>
        </div>
    </footer>
</body>
</html>