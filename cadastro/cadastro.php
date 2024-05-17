<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <header>
        <div class="container">
          <div class="logo"><img src="galpao logistico.png" alt=""></div>
          <nav>
            <ul>
              <li><a href="#">Home</a></li>
              <li><a href="#">About</a></li>
              <li><a href="#">Services</a></li>
              <li><a href="login.html">Login</a></li>
              <li><a href="cadastro.html">Cadastro</a></li>
            </ul>
          </nav>
          <div class="menu-toggle">Menu</div>
        </div>
      </header>
    <div class="form-container">
        
    <form class="form">
        <p class="form-title">Faça o cadastro</p>

        <div class="input-container">
          <p>
            <label for="nome">Nome:</label>
            <input type="text" placeholder="Digite seu nome">
          </p>
        </div>

        <div class="input-container">
          <p>
            <label for="cpf">CPF:</label>
            <input type="text" placeholder="Digite seu CPF">
          </p>
        </div>

        <div class="input-container">
          <p>
            <label for="email">E-mail:</label>
            <input type="text" placeholder="E-mail">
          </p>
        </div>

         <div class="input-container">
          <p>
            <label for="senha">Senha:</label>
            <input type="password" placeholder="Senha">
          </p>
        </div>

        <div class="input-container">
          <p>
            <label for="senha">Confirme a senha:</label>
            <input type="password" placeholder="Confirme a senha">
          </p>
        </div>

        <p> 
          <button type="submit" class="submit">Cadastrar</button>
        </p>
 
       <p class="link">
         Já possui conta? <a href="login.html">Login</a>
       </p>
       
    </form>
 
  </div>
</body>
</html>