<?php 
require_once('Conexao.php');

class Pedido {
    private $pedido_id;
    private $user_id;
    private $descricao;
    private $qntd;
    private $pesoKg;
    private $recebimento;
    private $entregaLimite;
    private $situacao;

    

    // CRUD methods
    public function cadastrarPedido() {
        try {
            $conn = Conexao::conectar();
            $sql = $conn->prepare("INSERT INTO pedidos (user_id, descricao, qntd, `peso-kg`, recebimento, `entrega-limite`, situacao) VALUES (:user_id, :descricao, :qntd, :pesoKg, :recebimento, :entregaLimite, :situacao)");

            $sql->bindValue(':user_id',  $this->getUser_id());
            $sql->bindValue(':descricao', $this->getDescricao());
            $sql->bindValue(':qntd', $this->getQntd());
            $sql->bindValue(':pesoKg', $this->getPesoKg());
            $sql->bindValue(':recebimento', $this->getRecebimento());
            $sql->bindValue(':entregaLimite', $this->getEntregaLimite());
            $sql->bindValue(':situacao', $this->getSituacao());

            $sql->execute();

            header('Location: ListarPedidos');
        } catch (PDOException $erro) {
            echo "Erro ao cadastrar pedido! " . $erro->getMessage();
        }
    }

    public function listar() {
        $conn = Conexao::conectar();
        $sql = "SELECT * FROM pedidos WHERE user_id = :user_id ORDER BY pedido_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarTudo(){
        $conn = Conexao::conectar();
        $sql = "SELECT * FROM pedidos ORDER BY pedido_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function buscar($id) {
        $conn = Conexao::conectar();
        $sql = $conn->prepare("SELECT * FROM logistica.pedidos WHERE pedido_id = :pedido_id");
        $sql->bindParam(':pedido_id', $id);
        $sql->execute();
        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar() {
        try {
            $conn = Conexao::conectar();
            $sql = $conn->prepare("UPDATE logistica.pedidos SET descricao = :descricao, qntd = :qntd, 'peso-kg' = :pesoKg, recebimento = :recebimento, 'entrega-limite' = :entregaLimite, situacao = :situacao WHERE pedido_id = :pedido_id");

            $sql->bindValue(':idLogistica', $this->getPedido_id());
            $sql->bindValue(':descricao', $this->getDescricao());
            $sql->bindValue(':qntd', $this->getQntd());
            $sql->bindValue(':pesoKg', $this->getPesoKg());
            $sql->bindValue(':recebimento', $this->getRecebimento());
            $sql->bindValue(':entregaLimite', $this->getEntregaLimite());
            $sql->bindValue(':situacao', $this->getSituacao());

            $sql->execute();
        } catch (PDOException $erro) {
            echo "Erro ao atualizar pedido! " . $erro->getMessage();
        }
    }

    public function deletar($id) {
        try {
            $conn = Conexao::conectar();
            $sql = $conn->prepare("DELETE FROM logistica.pedidos WHERE pedido_id = :pedido_id");
            $sql->bindValue(':pedido_id', $id);
            $sql->execute();
        } catch (PDOException $erro) {
            echo "Erro ao deletar pedido! " . $erro->getMessage();
        }
    }

    // Getters e Setters
    public function getPedido_id() { 
        return $this->pedido_id; 
    }

    public function setPedido_id($pedido_id) {
        $this->pedido_id = $pedido_id; 
    }

    public function getUser_id() { 
        return $this->user_id; 
    }

    public function setUser_id($user_id) {
        $this->user_id = $user_id; 
    }

    public function getDescricao() { 
        return $this->descricao; 
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function getQntd() {
        return $this->qntd;
    }

    public function setQntd($qntd) {
        $this->qntd = $qntd;
    }

    public function getPesoKg() {
        return $this->pesoKg;
    }

    public function setPesoKg($pesoKg) {
        $this->pesoKg = $pesoKg;
    }

    public function getRecebimento() {
        return $this->recebimento;
    }

    public function setRecebimento($recebimento) {
        $this->recebimento = $recebimento;
    }

    public function getEntregaLimite() {
        return $this->entregaLimite;
    }
    public function setEntregaLimite($entregaLimite) {
        $this->entregaLimite = $entregaLimite;
    }

    public function getSituacao() {
        return $this->situacao;
    }
    public function setSituacao($situacao) {
        $this->situacao = $situacao;
    }
}
?>
