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
if($permissao != 1){
    header('Location: PedirSuporte');
    exit();
}

include_once(__DIR__ . '/../../../Controller/SuporteController.php');
$SuporteController = new SuporteController();
$suportes = $SuporteController->listarSuporte();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/../../ProjetoFinalPhp/MVC/Assets/css/styles.css">
    <title>Listar Suportes</title>
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
    <h1>Lista de Suportes</h1>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>CPF</th>
                <th>Email</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($suportes as $suporte) ?>
                <tr>
                    <td><?= $suporte['suporteID'] ?? '' ?></td>
                    <td><?= $suporte['CpfUser'] ?? '' ?></td>
                    <td><?= $suporte['emailUser'] ?? '' ?></td>
                    <td><?= $suporte['Descricao'] ?? '' ?></td>
                    <td>
                        <button onclick="location.href='EditarSuporte&id=<?= $suporte['suporteID'] ?>';">Editar</button>
                        <button onclick="if(confirm('Tem certeza que deseja deletar?')) { location.href='DeletarSuporte&id=<?= $suporte['suporteID'] ?>'; }">Excluir</button>
                    </td>
                </tr>
        </tbody>
    </table>
    <footer>
        <div class="container">
            <p>&copy; 2024 Todos os direitos reservados. D&G Logística.</p>
        </div>
    </footer>
</body>
</html>