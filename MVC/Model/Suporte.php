<?php 
require_once('Conexao.php');

class Suporte{

    private $idSuporte;
    private $cpfUser;
    private $emailUser;
    private $descricao;
    
    public function cadastroSuporte(){
        try {
            $conn = Conexao::conectar();
            $sql = $conn->prepare("INSERT INTO suporte (cpfUser, emailUser, descricao) VALUES (:cpfUser, :emailUser, :descricao)");

            $sql->bindValue(':cpfUser', $this->getCpfUser());
            $sql->bindValue(':emailUser', $this->getEmailUser());
            $sql->bindValue(':descricao', $this->getDescricao());

            $sql->execute();
            print('<script>alert("Suporte cadastrado com sucesso!");</script>');
            print('<script>window.location.href = "index.php?url=Home";</script>');
            
        } catch (PDOException $erro) {
            echo "Erro ao cadastrar suporte! " . $erro->getMessage();
        }
    }

    public function listarSuporte(){
        try {
            $conn = Conexao::conectar();
            $sql = $conn->prepare("SELECT * FROM suporte");
            $sql->execute();

            return $sql->fetchAll();
        } catch (PDOException $erro) {
            echo "Erro ao listar suporte! " . $erro->getMessage();
        }
    }

    public function excluirSuporte($id){
        try {
            $conn = Conexao::conectar();
            $sql = $conn->prepare("DELETE FROM suporte WHERE suporteID = :id");
            $sql->bindValue(':id', $id);
            $sql->execute();
            print('<script>alert("Suporte excluído com sucesso!");</script>');
            print('<script>window.location.href = "index.php?url=SUPORTE";</script>');
        } catch (PDOException $erro) {
            echo "Erro ao excluir suporte! " . $erro->getMessage();
        }
    }

    //GETTERS E SETTERS
    public function getIdSuporte(){
        return $this->idSuporte;
    }

    public function setIdSuporte($idSuporte){
        $this->idSuporte = $idSuporte;
    }

    public function getCpfUser(){
        return $this->cpfUser;
    }

    public function setCpfUser($cpfUser){
        $this->cpfUser = $cpfUser;
    }

    public function getEmailUser(){
        return $this->emailUser;
    }

    public function setEmailUser($emailUser){
        $this->emailUser = $emailUser;
    }

    public function getDescricao(){
        return $this->descricao;
    }

    public function setDescricao($descricao){
        $this->descricao = $descricao;
    }
}
?>