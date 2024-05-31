<?php 
require_once(__DIR__ . '/../Model/Usuario.php');

class UsuarioController {

    public function processa($acao) {

        if ($acao == 'C') { // Create (INSERT)
            $novoUsuario = new Usuario();

            $novoUsuario->setNomeUsuario($_POST['nomeUsuario']);
            $novoUsuario->setEmail($_POST['email']);
            $novoUsuario->setCpf($_POST['cpf']);
            $novoUsuario->setDataNascimento($_POST['dataNascimento']);
            $novoUsuario->setSenha($_POST['senha']);

            $novoUsuario->cadastrarUsuario();
        }
    }

    //Envia o pedido de verificação para o model
    public function cpfExiste($cpf) {
        require_once(__DIR__ . '/../Model/Usuario.php');
        $usuario = new Usuario();
        return $usuario->verificarCpf($cpf);
    }
}
