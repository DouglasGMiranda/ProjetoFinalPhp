<?php 
session_start();
include('conexao.php');

$email = mysqli_real_escape_string($mysqli, trim($_POST['email']));
$nome = mysqli_real_escape_string($mysqli, trim($_POST['nome']));
$senha = mysqli_real_escape_string($mysqli, trim($_POST['senha']));
$cpf = mysqli_real_escape_string($mysqli, trim($_POST['cpf']));

$sql = "select count(*) as total from usuarios where email = '$email' or cpf = '$cpf'";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);

if($row['total'] == 1){
  $_SESSION['usuario_existe'] = true;
  header('Location: cadastro.php');
  exit;
}

$sql = "INSERT INTO usuarios (email, nome, senha, cpf) VALUES ('$email', '$nome', '$senha', '$cpf', NOW())";

if ($mysqli->query($sql) === true ){
    $_SESSION['status_cadastro'] = true;
}

$mysqli->close();
header('location: cadastro.php');
exit;
?>