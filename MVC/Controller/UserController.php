<?php 
require_once(__DIR__ . '/../Model/Usuario.php');

class UsuarioController {

    public function validaUser()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $nome = ($_POST['nomeUsuario']);
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
                // Aqui você pode armazenar os erros em uma sessão para exibir na página de cadastro
                session_start();
                $_SESSION['erros'] = $erros;
                header('Location: Cadastro');
                exit();
            } 
            else {
                // Processar o cadastro do usuário
                $this->processa('C', $nome, $email, $cpf, $dataNascimento, $senha);
            }
        }
    }

    public function processa($acao, $nome, $email, $cpf, $dataNascimento, $senha) {
        if ($acao == 'C') { // Create (INSERT)
            $novoUsuario = new Usuario();
            $novoUsuario->setNomeUsuario($nome);
            $novoUsuario->setEmail($email);
            $novoUsuario->setCpf($cpf);
            $novoUsuario->setDataNascimento($dataNascimento);
            $novoUsuario->setSenha($senha);

            $novoUsuario->cadastrarUsuario();
        }
    }

    public function cpfExiste($cpf) {
        $usuario = new Usuario();
        return $usuario->verificarCpf($cpf);
    }
}
?>
