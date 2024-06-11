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

    public function listarUsuarios() {
        $conn = Conexao::conectar();
        $sql = $conn->prepare("SELECT * FROM usuarios order by user_id");
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function atualizarUsuario($id) {
        try {
            $conn = Conexao::conectar();
            $sql = $conn->prepare("UPDATE usuarios SET nomeUsuario = :nomeUsuario, email = :email, cpf = :cpf, dataNascimento = :dataNascimento, senha = :senha, permissao = :permissao WHERE user_id = :user_id");

            $sql->bindValue(':user_id', $id);
            $sql->bindValue(':nomeUsuario', $this->getNomeUsuario());
            $sql->bindValue(':email', $this->getEmail());
            $sql->bindValue(':cpf', $this->getCpf());
            $sql->bindValue(':dataNascimento', $this->getDataNascimento());
            $sql->bindValue(':senha', $this->getSenha());
            $sql->bindValue(':permissao', $this->getPermissao());

            $sql->execute();
            header('Location: Usuarios');
        } catch (PDOException $erro) {
            echo "Erro ao atualizar usuário! " . $erro->getMessage();
        }
    }

    public function buscarUsuario($id) {
        $conn = Conexao::conectar();
        $sql = $conn->prepare("SELECT * FROM usuarios WHERE user_id = :user_id");
        $sql->bindParam(':user_id', $id);
        $sql->execute();
        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    public function buscarUsuarioPorEmail($email) {
        $conn = Conexao::conectar();
        $sql = $conn->prepare("SELECT * FROM usuarios WHERE email = :email");
        $sql->bindParam(':email', $email);
        $sql->execute();
        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    public function deletarUsuario($id) {
        try {
            $conn = Conexao::conectar();
            $sql = $conn->prepare("DELETE FROM usuarios WHERE user_id = :user_id");
            $sql->bindValue(':user_id', $id);
            $sql->execute();
            echo "<script>
            alert('Usuario deletado com sucesso!');
            window.location.href = 'Usuarios';
        </script>";
        } catch (PDOException $erro) {
            echo "Erro ao deletar usuário! " . $erro->getMessage();
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

    public function getPermissao() {
        return $this->permissao;
    }

    public function setPermissao($permissao) {
        $this->permissao = $permissao;
    }
}
?>
