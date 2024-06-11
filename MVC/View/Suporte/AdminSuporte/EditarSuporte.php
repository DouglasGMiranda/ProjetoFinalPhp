<?php 
include_once(__DIR__ . '/../../../config.php');

if (isset($_SESSION['usuario']) && isset($_SESSION['usuario']['permissao'])) {
    $permissao = $_SESSION['usuario']['permissao'];
} else {
    $permissao = null;
}

if($permissao == 1){
    include_once(__DIR__ . '/../../../Controller/SuporteController.php');
    $suporteController = new SuporteController();
    if (isset($_GET['id']) && !empty($_GET['id'])) {
    
        $id = $_GET['id'];
        $suporte = $suporteController->buscarSuporte($id);
        $erros = $_SESSION['erros'] ?? [];
        unset($_SESSION['erros']);
    }
}
else{
    header('Location: Suporte');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/../../ProjetoFinalPhp/MVC/Assets/css/styles.css">
    <title>Editar Suporte</title>
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
    <h1>Editar Suporte</h1>

    <form method="POST" action="index.php?url=AtualizarSuporte">

    <label for="SuporteID">Suporte ID :<?php print $suporte['SuporteID']?></label>
    <input type="hidden" name="SuporteID" id="SuporteID" value="<?php print $suporte['SuporteID'] ?>">

    <label>CPF User:</label>
    <input type="text" name="CpfUser" id="CpfUser" value="<?php print $suporte['CpfUser'] ?>" maxlength="11"><br><br>

    <label>Email User:</label>
    <input type="text" name="EmailUser" id="EmailUser" value="<?php print $suporte['EmailUser'] ?>" maxlength="120"><br><br>

    <label>Descricao:</label>
    <input type="text" name="Descricao" id="Descricao" value="<?php print $suporte['Descricao'] ?>" maxlength="300"><br><br>

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