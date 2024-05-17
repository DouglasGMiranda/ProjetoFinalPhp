<?php 

$usuario = 'root';
$senha = '';
$database = 'logistica';
$host = 'localhost';

$mysqli = new mysqli($host, $usuario, $senha, $database);

if ($mysqli->error){
    die("Erro na conexão com o banco de dados: " . $mysqli->error);
}

?>