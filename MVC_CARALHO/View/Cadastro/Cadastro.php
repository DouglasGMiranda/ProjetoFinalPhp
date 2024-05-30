<?php 
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        
        $nome = $_POST['nomeUsuario'];
        $email = $_POST['email'];
        $cpf = $_POST['cpf'];
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);
        $dataNascimento = $_POST['dataNascimento'];
        $senha = $_POST['senha'];
        $confSenha = $_POST['confSenha'];
        $erros = [];


        // Validação do Nome
        if (empty($nome) || strlen($nome) < 3 || strlen($nome) > 100 || !preg_match("/^[a-zA-Z-' ]*$/", $nome)){
            $erros[] = "O nome deve ter entre 3 e 100 caracteres e deve conter apenas letras e espaço.";
        }

        // Validação do Email
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erros[] = "Formato de email inválido.";
        }

        // Validação do CPF
        elseif (!preg_match("/^\d{11}$/", $cpf)) {
            $erros[] = "O CPF deve conter 11 dígitos.";
        }


    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>
<body>
    <header>
        <div class="cabecalho">
            <div class="logo">A nossa logo</div>
            <nav>
                <ul>
                    <li><a href="Login">Login</a></li>
                    <li><a href="Cadastro">Cadastro</a></li>
                    <li><a href="Home">Home</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <h1>Cadastrar</h1>

    <form method="POST" action="index.php?url=cadastrarUsuario">

        <label>Nome:</label>
        <input type="text" name="nomeUsuario" id="nomeUsuario" placeholder="Nome completo"><br><br>

        <label>Email</label>
        <input type="text" name="email" id="email" placeholder="email@gmail.com"><br><br>

        <label>CPF</label>
        <input type="text" name="cpf" id="cpf" placeholder="12345678910" maxlength="11"><br><br>

        <label>Data de Nascimento</label>
        <input type="text" name="dataNascimento" id="dataNascimento" placeholder="DD/MM/AAAA" maxlength="10"><br><br>

        <label>Senha</label>
        <input type="password" name="senha" id="senha" placeholder="Digite sua senha"><br><br>

        <label>Confirme sua senha</label>
        <input type="password" name="confSenha" id="confSenha" placeholder="Confirme sua senha"><br><br>

        <button type="submit" name="cadastrarUsu">Cadastrar</button>

    </form>
</body>
</html>