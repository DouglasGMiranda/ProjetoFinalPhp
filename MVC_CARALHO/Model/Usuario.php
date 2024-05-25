<?php 

require_once('Model/Conexao.php');


class Usuario {

    // Atributos
    private $idUsuario;
    private $nomeUsuario;
    private $email;
    private $cpf;
    private $dataNascimento;
    private $senha;

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
            echo "Usuário cadastrado com sucesso!";
        } catch (PDOException $erro) {
            echo "Erro ao cadastrar usuário! " . $erro->getMessage();
        }
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
