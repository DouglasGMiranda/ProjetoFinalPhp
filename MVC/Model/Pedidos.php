<?php 
require_once('Conexao.php');

class Pedido {
    private $pedido_id;
    private $user_id;
    private $descricaoProduto;
    private $quantidade;
    private $peso;
    private $dataRecebimento;
    private $dataEntrega;
    private $status;

    

    // CRUD methods
    public function cadastrar() {
        try {
            $conn = Conexao::conectar();
            $sql = $conn->prepare("INSERT INTO pedidos (user_id, descricao, qntd, peso-kg, recebimento, entrega-limite, status) VALUES (:user_id, :descricaoProduto, :quantidade, :peso, :dataRecebimento, :dataEntrega, :status)");

            $sql->bindValue(':user_id',  $this->getUser_id());
            $sql->bindValue(':descricaoProduto', $this->getDescricaoProduto());
            $sql->bindValue(':quantidade', $this->getQuantidade());
            $sql->bindValue(':peso', $this->getPeso());
            $sql->bindValue(':dataRecebimento', $this->getDataRecebimento());
            $sql->bindValue(':dataEntrega', $this->getDataEntrega());
            $sql->bindValue(':status', $this->getStatus());

            $sql->execute();
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
            $sql = $conn->prepare("UPDATE logistica.pedidos SET descricao = :descricaoProduto, qntd = :quantidade, peso-kg = :peso, recebimento = :dataRecebimento, entrega-limite = :dataEntrega, status = :status WHERE pedido_id = :pedido_id");

            $sql->bindValue(':idLogistica', $this->getPedido_id());
            $sql->bindValue(':descricaoProduto', $this->getDescricaoProduto());
            $sql->bindValue(':quantidade', $this->getQuantidade());
            $sql->bindValue(':peso', $this->getPeso());
            $sql->bindValue(':dataRecebimento', $this->getDataRecebimento());
            $sql->bindValue(':dataEntrega', $this->getDataEntrega());
            $sql->bindValue(':status', $this->getStatus());

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

    public function getDescricaoProduto() { 
        return $this->descricaoProduto; 
    }

    public function setDescricaoProduto($descricaoProduto) {
        $this->descricaoProduto = $descricaoProduto;
    }

    public function getQuantidade() {
        return $this->quantidade;
    }

    public function setQuantidade($quantidade) {
        $this->quantidade = $quantidade;
    }

    public function getPeso() {
        return $this->peso;
    }

    public function setPeso($peso) {
        $this->peso = $peso;
    }

    public function getDataRecebimento() {
        return $this->dataRecebimento;
    }

    public function setDataRecebimento($dataRecebimento) {
        $this->dataRecebimento = $dataRecebimento;
    }

    public function getDataEntrega() {
        return $this->dataEntrega;
    }
    public function setDataEntrega($dataEntrega) {
        $this->dataEntrega = $dataEntrega;
    }

    public function getStatus() {
        return $this->status;
    }
    public function setStatus($status) {
        $this->status = $status;
    }
}
?>
