<?php 
include_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../Model/Usuario.php');

class UsuarioController {

    public function validaUser() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nome = $_POST['nomeUsuario'];
            $email = $_POST['email'];
            $cpf = preg_replace('/[^0-9]/is', '', $_POST['cpf']);
            $dataNascimento = $_POST["dataNascimento"];
            $senha = $_POST['senha'];
            $confSenha = $_POST['confSenha'];
            $erros = [];

            // Validação do Nome
            if (empty($nome) || strlen($nome) < 3 || strlen($nome) > 100 || !preg_match("/^[a-zA-Z-' ]*$/", $nome)) {
                $erros[] = "O nome deve ter entre 3 e 100 caracteres e deve conter apenas letras e espaço.";
            }

            // Validação do Email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $erros[] = "Formato de email inválido.";
            } else {
                if ($this->emailExiste($email)) {
                    $erros[] = "Email já cadastrado.";
                }
            }

            // Validação do CPF
            if (!preg_match("/^\d{11}$/", $cpf)) {
                $erros[] = "O CPF deve conter 11 dígitos.";
            } else {
                if ($this->cpfExiste($cpf)) {
                    $erros[] = "CPF já cadastrado.";
                }
            }

            // Validação da Data de Nascimento
            if (empty($dataNascimento) || !preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $dataNascimento)) {
                $erros[] = "Data de nascimento inválida. Use o formato DD/MM/AAAA.";
            } else {
                $dataNascimentoObj = DateTime::createFromFormat('d/m/Y', $dataNascimento);
                if ($dataNascimentoObj === false) {
                    $erros[] = "Data de nascimento inválida. Use o formato DD/MM/AAAA.";
                } else {
                    $hoje = new DateTime();
                    $idade = $hoje->diff($dataNascimentoObj)->y;
                    if ($idade < 18) {
                        $erros[] = "Você deve ter pelo menos 18 anos.";
                    }
                }
            }

            // Validar senha
            if (empty($senha) || strlen($senha) < 6) {
                $erros[] = "A senha deve ter pelo menos 6 caracteres.";
            }

            // Validar confirmação de senha
            if ($senha !== $confSenha) {
                $erros[] = "As senhas não conferem.";
            }

            // Exibir erros
            if (!empty($erros)) {
                $_SESSION['erros'] = $erros;
                header('Location: Cadastro');
                exit();
            } else {
                // Processar o cadastro do usuário
                $this->processa('C',null, $nome, $email, $cpf, $dataNascimento, $senha, null);
            }
        }
    }

    public function listarUsuarios() {
        return $this->processa('R', null, null, null, null, null, null, null, null);
    }
    public function atualizarUsuario(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['user_id'];
            $nome = $_POST['nomeUsuario'];
            $email = $_POST['email'];
            $cpf = preg_replace('/[^0-9]/is', '', $_POST['cpf']);
            $dataNascimento = $_POST["dataNascimento"];
            $senha = $_POST['senha'];
            $confSenha = $_POST['confSenha'];
            $permissao = $_POST['permissao'];
            $user = $this->buscarUsuario($id);
            $erros = [];

            // Validação do Nome
            if (empty($nome) || strlen($nome) < 3 || strlen($nome) > 100 || !preg_match("/^[a-zA-Z-' ]*$/", $nome)) {
                $erros[] = "O nome deve ter entre 3 e 100 caracteres e deve conter apenas letras e espaço.";
            }

            // Validação do Email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $erros[] = "Formato de email inválido.";
            } 
            elseif ($email != $user['email']) {
                if ($this->emailExiste($email)) {
                    $erros[] = "Email já cadastrado.";
                }
            }

            // Validação do CPF
            if (!preg_match("/^\d{11}$/", $cpf)) {
                $erros[] = "O CPF deve conter 11 dígitos.";
            } 
            elseif ($cpf != $user['cpf']) {
                if ($this->cpfExiste($cpf)) {
                    $erros[] = "CPF já cadastrado.";
                }
            }

            // Validação da Data de Nascimento
            if (empty($dataNascimento) || !preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $dataNascimento)) {
                $erros[] = "Data de nascimento inválida. Use o formato DD/MM/AAAA.";
            } else {
                $dataNascimentoObj = DateTime::createFromFormat('d/m/Y', $dataNascimento);
                if ($dataNascimentoObj === false) {
                    $erros[] = "Data de nascimento inválida. Use o formato DD/MM/AAAA.";
                } else {
                    $hoje = new DateTime();
                    $idade = $hoje->diff($dataNascimentoObj)->y;
                    if ($idade < 18) {
                        $erros[] = "Você deve ter pelo menos 18 anos.";
                    }
                }
            }

            // Validar senha
            if (empty($senha) || strlen($senha) < 6) {
                $erros[] = "A senha deve ter pelo menos 6 caracteres.";
            }

            // Validar confirmação de senha
            if ($senha !== $confSenha) {
                $erros[] = "As senhas não conferem.";
            }

            if (empty($permissao)) {
                $erros[] = "Selecione uma permissão.";
            }
            elseif ($permissao !=1 || $permissao != 0) {
                $erros[] = "Permissão inválida.";
            }

            // Exibir erros
            if (!empty($erros)) {
                $_SESSION['erros'] = $erros;
                header('Location: EDITARUSUARIO');
                exit();

            } else {
                // Processar o cadastro do usuário
                $this->processa('U', $id, $nome, $email, $cpf, $dataNascimento, $senha, $permissao);
            }
        }
    }

    public function excluirUsuario($id) {
        $usuario = new Usuario();
        $usuario->deletarUsuario($id);
    }

    public function processa($acao, $id, $nome, $email, $cpf, $dataNascimento, $senha, $permissao) {
        if ($acao == 'C') {
            $dataNasc = explode("/", $dataNascimento);
            $dataNascimento = $dataNasc[2] . "-" . $dataNasc[1] . "-" . $dataNasc[0];

            $cpf = preg_replace('/[^0-9]/', '', $cpf);

            $novoUsuario = new Usuario();
            $novoUsuario->setNomeUsuario($nome);
            $novoUsuario->setEmail($email);
            $novoUsuario->setCpf($cpf);
            $novoUsuario->setDataNascimento($dataNascimento);
            $novoUsuario->setSenha($senha);

            $novoUsuario->cadastrarUsuario();
            header('Location: Login');
        }

        elseif ($acao == 'R') {
            $usuario = new Usuario();
            return $usuario->listarUsuarios();
        }

        elseif ($acao == 'U') {
            $dataNasc = explode("/", $dataNascimento);
            $dataNascimento = $dataNasc[2] . "-" . $dataNasc[1] . "-" . $dataNasc[0];

            $cpf = preg_replace('/[^0-9]/', '', $cpf);

            $usuario = new Usuario();
            $usuario->setNomeUsuario($nome);
            $usuario->setEmail($email);
            $usuario->setCpf($cpf);
            $usuario->setDataNascimento($dataNascimento);
            $usuario->setSenha($senha);
            $usuario->setPermissao($permissao);

            $usuario->atualizarUsuario($id);
        }
    }

    public function cpfExiste($cpf) {
        $usuario = new Usuario();
        return $usuario->verificarCpf($cpf);
    }

    public function emailExiste($email) {
        $usuario = new Usuario();
        return $usuario->verificarEmail($email);
    }

    public function logar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $senha = $_POST['senha'];
    
            $usuario = new Usuario();
            $usuarioEncontrado = $usuario->logar($email, $senha);
    
            if ($usuarioEncontrado) {
                $id_user = $usuario->getUserID($email);
                $nome_user = $usuario->getNomeUsuario($email);
                $email_user = $usuario->getEmail($email);
                $permissao = $usuario->verificarPermissao($email);
    
                $_SESSION['usuario'] = [
                    'idUsuario' => $id_user,
                    'nome' => $nome_user,
                    'email' => $email_user,
                    'permissao' => $permissao
                ];
                header('Location: Home');
                exit();
            } else {
                $_SESSION['erros'] = ["Email ou senha inválidos."];
                header('Location: Login');
                exit();
            }
        }
    }
    
    
    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header('Location: Login');
    }

    public function buscarUsuario($id){
        $usuario = new Usuario();
        return $usuario->buscarUsuario($id);
    }
}
?>
