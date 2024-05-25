<?php 
include('conexao/conexao.php');
$exibir = '';
if(isset($_POST['email']) || isset($_POST['senha'])){

  if((strlen($_POST['email']) == 0) && (strlen($_POST['senha']) == 0)){
    $exibir = "Preencha seu e-mail e sua senha"; 
  } else if(strlen($_POST['email']) == 0){
    $exibir = "Preencha seu email";
  } else if(strlen($_POST['senha']) == 0){
    $exibir = "Preencha sua senha";
  } else {

    $email = $mysqli->real_escape_string($_POST['email']);
    $senha = $mysqli->real_escape_string($_POST['senha']);

    $sql_code = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
    $sql_query = $mysqli->query($sql_code) or die("Falha na execução do codigo SQL: " . $mysqli->error);

    $quantidade = $sql_query->num_rows;

    if($quantidade == 1){
      $exibir = "Login efetuado com sucesso";
      $usuario = $sql_query->fetch_assoc();

      if(!isset($_SESSION)){
        session_start();
      }

      $_SESSION['id'] = $usuario['id'];
      $_SESSION['nome'] = $usuario['nome'];

      header("Location: /trabalho/ProjetoFinalPhp/home/home.php");

    } else {
      $exibir = "Falha ao logar! E-mail ou senha incorretos";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
  <header>
    <div class="container">
      <div class="logo">Your Logo</div>
      <nav>
        <ul>
          <li><a href="/trabalho/ProjetoFinalPhp/home/home.php">Home</a></li>
          <li><a href="#">About</a></li>
          <li><a href="#">Services</a></li>
          <li><a href="/trabalho/ProjetoFinalPhp/index.php">Login</a></li>
          <li><a href="/trabalho/ProjetoFinalPhp/cadastro/cadastro.php">Cadastro</a></li>
          <li><a href="../logout.php">Logout</a></li>
        </ul>
      </nav>
      <div class="menu-toggle">Menu</div>
    </div>
  </header>
    <div class="form-container">
        
    <form action="" method="POST" class="form">
        
      <p class="form-title">Faça login em sua conta</p>
         
      <div class="input-container">
        <p>
          <label for="email">E-mail</label>
          <input type="text" name="email" placeholder="Digite seu E-mail">
        </p>
      </div>

      <p>
      <div class="input-container">
        <label for="senha">Senha</label>
        <input type="password" name="senha" placeholder="Digite sua Senha">
      </div>
      </p>
       
      <p>
      <button type="submit" class="submit">Entrar</button>
      </p>

      <p>
      <?php if (!empty($exibir)) : ?>
                    <p><?php echo $exibir ?></p>
                <?php endif; ?>
      </p>

    <p class="link">
      Sem conta? <a href="/trabalho/ProjetoFinalPhp/cadastro/cadastro.php">Inscrever-se</a>
    </p>
    
    </form>
  </div>
</body>
</html>