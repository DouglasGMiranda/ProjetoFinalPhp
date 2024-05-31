<?php 
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        
        $nome = $_POST['nomeUsuario'];
        $email = $_POST['email'];
        $cpf = $_POST['cpf'];
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);
        $dataNascimento = $_POST["dataNascimento"];
        $senha = $_POST['senha'];
        $confSenha = $_POST['confSenha'];
        $erros = [];


        // Validação do Nome
        if (empty($nome) || strlen($nome) < 3 || strlen($nome) > 100 || !preg_match("/^[a-zA-Z-' ]*$/", $nome)){
            $erros[] = "O nome deve ter entre 3 e 100 caracteres e deve conter apenas letras e espaço.";
        }

        // Validação do Email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erros[] = "Formato de email inválido.";
        }

        // Validação do CPF
        if (!preg_match("/^\d{11}$/", $cpf)) {
            $erros[] = "O CPF deve conter 11 dígitos.";
        }

        else {
            require_once("Controller/usuarioController.php");
            $controle = new usuarioController();

            if ($controle->cpfExiste($cpf)) {
            $errors[] = "CPF já cadastrado.";
            }
        }

        
        // Validação da Data de Nascimento
        if (empty($dataNascimento) || !preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $dataNascimento)) {
            $errors[] = "Data de nascimento inválida. Use o formato DD/MM/AAAA.";
        } 
        
        else {
            $dataNascimentoObj = DateTime::createFromFormat('d/m/Y', $dataNascimento);

            if ($dataNascimentoObj === false) {
                $errors[] = "Data de nascimento inválida. Use o formato DD/MM/AAAA.";
            } 
            
            else {
                $hoje = new DateTime();
                $idade = $hoje->diff($dataNascimentoObj)->y;

                if ($idade < 18) {
                    $errors[] = "Você deve ter pelo menos 18 anos.";
                }
            }
        }

        // Validar senha
        if (empty($_POST["senha"]) || strlen($_POST["senha"]) < 6) {
            $errors[] = "A senha deve ter pelo menos 6 caracteres.";
        }

        // Validar confirmação de senha
        if ($senha !== $confSenha) {
            $errors[] = "As senhas não conferem.";
        }

        // Exibir erros
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo "<p>$error</p>";
            }
        } 
        
        else {
            // Processar o cadastro do usuário
            action="index.php?url=cadastrarUsuario"
            echo "Usuário cadastrado com sucesso!";
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

    <form method="POST">

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