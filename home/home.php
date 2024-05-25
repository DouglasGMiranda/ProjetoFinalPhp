<?php 
include("protect.php");
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
<title>Advanced Header Menu</title>
</head>
<body>
  Bem vindo a home do site, <?php echo $_SESSION['nome'];?>

<header>
  <div class="container">
    <div class="logo">Your Logo</div>
    <nav>
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Services</a></li>
        <li><a href="login.html">Login</a></li>
        <li><a href="cadastro.html">Cadastro</a></li>
        <li><a href="../logout.php">Logout</a></li>
      </ul>
    </nav>
    <div class="menu-toggle">Menu</div>
  </div>
</header>

<script>
  // Toggle mobile menu
  const menuToggle = document.querySelector('.menu-toggle');
  const menu = document.querySelector('nav');

  menuToggle.addEventListener('click', () => {
    menu.classList.toggle('menu-open');
  });
</script>

</body>
</html>
