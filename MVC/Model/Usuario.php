<?php 
require_once('Conexao.php');

class Usuario {

    private $idUsuario;
    private $nomeUsuario;
    private $email;
    private $cpf;
    private $dataNascimento;
    private $senha;
    private $permissao;

    public function cadastrarUsuario() {
        try {
            $conn = Conexao::conectar();
            $sql = $conn->prepare("INSERT INTO usuarios (nomeUsuario, email, cpf, dataNascimento, senha) VALUES (:nomeUsuario, :email, :cpf, :dataNascimento, :senha)");

            $sql->bindValue(':nomeUsuario', $this->getNomeUsuario());
            $sql->bindValue(':email', $this->getEmail());
            $sql->bindValue(':cpf', $this->getCpf());
            $sql->bindValue(':dataNascimento', $this->getDataNascimento());
            $sql->bindValue(':senha', $this->getSenha());

            $sql->execute();
            header('Location: Home');
        } catch (PDOException $erro) {
            echo "Erro ao cadastrar usuário! " . $erro->getMessage();
        }
    }

    public function verificarCpf($cpf) {
        $conn = Conexao::conectar();
        $sql = $conn->prepare("SELECT COUNT(*) FROM usuarios WHERE cpf = :cpf");
        $sql->bindParam(':cpf', $cpf);
        $sql->execute();
        return $sql->fetchColumn() > 0;
    }

    public function verificarEmail($email) {
        $conn = Conexao::conectar();
        $sql = $conn->prepare("SELECT COUNT(*) FROM usuarios WHERE email = :email");
        $sql->bindParam(':email', $email);
        $sql->execute();
        return $sql->fetchColumn() > 0;
    }

    public function verificarPermissao($email){
        $conn = Conexao::conectar();
        $sql = $conn->prepare("SELECT permissao FROM usuarios WHERE email = :email");
        $sql->bindParam(':email', $email);
        $sql->execute();
        return $sql->fetchColumn();
    }

    public function getUserID($email) {
        $conn = Conexao::conectar();
        $sql = $conn->prepare("SELECT user_id FROM usuarios WHERE email = :email");
        $sql->bindParam(':email', $email);
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_ASSOC);
        return $result['user_id'];
    }

    public function logar($email, $senha) {
        $conn = Conexao::conectar();
        $sql = $conn->prepare("SELECT COUNT(*) FROM usuarios WHERE email = :email AND senha = :senha");
        $sql->bindParam(':email', $email);
        $sql->bindParam(':senha', $senha);
        $sql->execute();
        return $sql->fetchColumn();
    }
    

    // Getters e Setters
    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    public function getNomeUsuario() {
        return $this->nomeUsuario;
    }

    public function setNomeUsuario($nomeUsuario) {
        $this->nomeUsuario = $nomeUsuario;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    public function getDataNascimento() {
        return $this->dataNascimento;
    }

    public function setDataNascimento($dataNascimento) {
        $this->dataNascimento = $dataNascimento;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }
}
?>
