<?php
include_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../Model/Pedidos.php');
require_once(__DIR__ . '/../Model/Usuario.php');

class PedidosController {

    public function __construct() {
        if (!isset($_SESSION['usuario'])) {
            header('Location: Login');
            exit();
        }
    }

    public function cadastrarPedidos() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_id = $_SESSION['user_id'];
            $descricaoProduto = $_POST['descricaoProduto'];
            $quantidade = $_POST['quantidade'];
            $peso = $_POST['peso'];
            $dataRecebimento = $_POST['dataRecebimento'];
            $status = 0; // Status inicial

            

            $erros = [];

            if (empty($descricaoProduto) || strlen($descricaoProduto) > 200) {
                $erros[] = "A descrição do produto deve ter até 200 caracteres.";
            }

            if (!is_numeric($quantidade) || $quantidade < 1 || $quantidade > 100) {
                $erros[] = "A quantidade deve ser um número entre 1 e 100.";
            }

            if (empty($peso) || !is_numeric($peso) || strlen($peso) > 8) {
                $erros[] = "O peso deve ter até 8 numeros.";
            }

            if (empty($dataRecebimento) || !preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $dataRecebimento)) {
                $erros[] = "Data de recebimento inválida. Use o formato DD/MM/AAAA.";
            }
            else{
                $dataRecebimentoObj = DateTime::createFromFormat('d/m/Y', $dataRecebimento);
                $dataEntregaObj = clone $dataRecebimentoObj;
                $dataEntregaObj->modify('+7 day');
            }

            if (!empty($erros)) {
                $_SESSION['erros'] = $erros;
                header('Location: CadastroPedido');
                exit();
            } 
            
            else {
                $Pedido = new Pedido();
                $Pedido->setUser_id($user_id);
                $Pedido->setDescricaoProduto($descricaoProduto);
                $Pedido->setQuantidade($quantidade);
                $Pedido->setPeso($peso);
                $Pedido->setDataRecebimento($dataRecebimentoObj->format('Y-m-d'));
                $Pedido->setDataEntrega($dataEntregaObj->format('Y-m-d'));
                $Pedido->setStatus($status);

                $Pedido->cadastrar();
                header('Location: ListarPedidos');
            }
        }
    }

    public function listarPedido() {
        $Pedido = new Pedido();
        return $Pedido->listar();
    }

    public function buscarPedido($id) {
        $Pedido = new Pedido();
        return $Pedido->buscar($id);
    }

    public function atualizarPedido() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $pedido_id = $_POST['pedido_id'];
            $descricaoProduto = $_POST['descricaoProduto'];
            $quantidade = $_POST['quantidade'];
            $peso = $_POST['peso'];
            $dataRecebimento = $_POST['dataRecebimento'];
            $status = $_POST['status'];

            $dataRecebimentoObj = DateTime::createFromFormat('d/m/Y', $dataRecebimento);
            $dataEntregaObj = clone $dataRecebimentoObj;
            $dataEntregaObj->modify('+7 day');

            $erros = [];

            if (empty($descricaoProduto) || strlen($descricaoProduto) > 200) {
                $erros[] = "A descrição do produto deve ter até 200 caracteres.";
            }

            if (!is_numeric($quantidade) || $quantidade < 1 || $quantidade > 100) {
                $erros[] = "A quantidade deve ser um número entre 1 e 100.";
            }

            if (empty($peso) || strlen($peso) > 8) {
                $erros[] = "O peso deve ter até 8 caracteres.";
            }

            if (empty($dataRecebimento) || !preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $dataRecebimento)) {
                $erros[] = "Data de recebimento inválida. Use o formato DD/MM/AAAA.";
            }

            if (!empty($erros)) {
                $_SESSION['erros'] = $erros;
                header("Location: EditarPedido?id=$pedido_id");
                exit();
            } 
            
            else {
                $Pedido = new Pedido();
                $Pedido->setPedido_id($pedido_id);
                $Pedido->setDescricaoProduto($descricaoProduto);
                $Pedido->setQuantidade($quantidade);
                $Pedido->setPeso($peso);
                $Pedido->setDataRecebimento($dataRecebimentoObj->format('Y-m-d'));
                $Pedido->setDataEntrega($dataEntregaObj->format('Y-m-d'));
                $Pedido->setStatus($status);

                $Pedido->atualizar();
                header('Location: ListaPedido');
            }
        }
    }

    public function deletarPedido($id) {
        $Pedido = new Pedido();
        $Pedido->deletar($id);
        header('Location: ListaPedido');
    }
}
?>
