<?php
// Verificar se a sessão já foi iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Iniciar a sessão se ainda não tiver sido iniciada
}

// Inicializar a variável de permissões
$permissao = isset($_SESSION['usuario']['permissao']) ? $_SESSION['usuario']['permissao'] : null; 
?> 

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/../../PROJETOFINALPHP/MVC/Assets/css/styles.css">
    <title>Document</title>
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
    <main>
        <h3 class="texto">MISSÃO VALORES E PRINCIPOS DA D&G</h3>
        <br>
        <h1>UM POUCO MAIS SOBRE A D&G</h1>
        <div class="sobre">
            <div class="quadrado">
                <h3>MISSÃO</h3>
                <br>
                <p>Facilitar o transporte global com eficiência, segurança e sustentabilidade.</p>
            </div>
            <div class="quadrado">
                <h3>VALORES</h3>
                <br>
                <p>Integridade, inovação e colaboração para excelência na logística.</p>
            </div>
            <div class="quadrado">
                <h3>PRINCIPOS</h3>
                <br>
                <li>Transparência</li>
                <li>Colaboração</li>
                <li>Inovação</li>
                <li>Eficiência</li>
                <li>Confiança</li>
                <li>Sustentabilidade</li>
            </div>
        </div>
    </main>
    <div class="nos">
        <h1>MAIS UM POUCO SOBRE NÓS</h1>
        <p>Na D&G, não apenas entregamos produtos, mas também realizamos sonhos. Somos uma equipe apaixonada que se dedica a fornecer soluções logísticas que não apenas atendem, mas excedem as expectativas de nossos clientes.</p><br>
        <p>Com uma abordagem centrada no cliente e uma mentalidade inovadora, buscamos constantemente novas maneiras de simplificar e aprimorar o processo logístico. Da embalagem à entrega, cada etapa é cuidadosamente planejada e executada para garantir eficiência, confiabilidade e satisfação do cliente.</p><br>  
        <p>Nosso compromisso com a excelência se estende além dos serviços que oferecemos. Estamos empenhados em construir relacionamentos sólidos e duradouros com nossos clientes, baseados na confiança, transparência e integridade.</p><br>
        <p>Na D&G, não apenas movemos mercadorias, mas também construímos conexões. Conexões entre empresas e seus clientes, entre pessoas e seus sonhos. Estamos aqui para tornar o mundo um lugar mais conectado, acessível e próspero. Junte-se a nós em nossa jornada rumo a um futuro logístico brilhante e inspirador.</p>
    </div>
</body>
<footer>
        <div class="container">
            <p>&copy; 2024 Todos os direitos reservados. D&G Logística.</p>
        </div>
    </footer>
</html>
