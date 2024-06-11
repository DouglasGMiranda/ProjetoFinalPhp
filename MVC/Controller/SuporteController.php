<?php
include_once(__DIR__ . '/../Model/Conexao.php'); 
include_once(__DIR__ . '/../Model/Suporte.php');
include_once(__DIR__ . '/../Model/Usuario.php');

class SuporteController{

    public function cadastrarSuporte(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $cpfUser = $_POST['cpfUser'];
            $emailUser = $_POST['emailUser'];
            $descricao = $_POST['Descricao'];
            $erros = [];

            if (empty($cpfUser) || !preg_match("/^\d{11}$/", $cpfUser)) {
                $erros[] = "CPF deve ter 11 numeros.";
            }
            else{
                $usuario = new Usuario();
                $usuario->verificarCpf($cpfUser);
                if ($usuario->verificarCpf($cpfUser) == false) {
                    $erros[] = "CPF não cadastrado.";
                }
            }

            if (empty($emailUser) || !filter_var($emailUser, FILTER_VALIDATE_EMAIL)) {
                $erros[] = "Email inválido.";
            }
            else{
                $usuario = new Usuario();
                $usuario->verificarEmail($emailUser);
                if ($usuario->verificarEmail($emailUser) == false) {
                    $erros[] = "Email não cadastrado.";
                }

                else{
                    $usuario = new Usuario();
                    $usuario = $usuario->buscarUsuarioPorEmail($emailUser);
            
                    if ($usuario['email'] != $emailUser || $usuario['cpf'] != $cpfUser) {
                        $erros[] = "Email ou CPF não incorretos.";
                    }
                }
            }

            if (empty($descricao) || strlen($descricao) > 300) {
                $erros[] = "A descrição do problema deve ter até 300 caracteres e não pode estar vazia.";
            }

            if (!empty($erros)) {
                $_SESSION['erros'] = $erros;
                header('Location: Suporte');
                exit();
            } 
            else {
               $this->processa('C',null, $cpfUser, $emailUser, $descricao);
            }
        }
    }

    public function listarSuporte(){
        return $this->processa('R',null, null, null, null);
    }

    public function excluirSuporte($id){
        $this->processa('D', $id, null, null, null);
    }

    public function processa($acao, $SuporteID, $cpfUser, $emailUser, $descricao){
        if ($acao == 'C') {
            $Suporte = new Suporte();
            $Suporte->setCpfUser($cpfUser);
            $Suporte->setEmailUser($emailUser);
            $Suporte->setDescricao($descricao);

            $Suporte->cadastroSuporte();
        }

        if ($acao == 'R') {
            $Suporte = new Suporte();
            return $Suporte->listarSuporte();
        }

        /*if ($acao == 'U') {
            $Suporte = new Suporte();
            $Suporte->setCpfUser($cpfUser);
            $Suporte->setEmailUser($emailUser);
            $Suporte->setDescricao($descricao);

            $Suporte->atualizarSuporte();
        }*/

        if ($acao == 'D') {
            $Suporte = new Suporte();
            $Suporte->excluirSuporte($SuporteID);
        }
    }
}

?>

