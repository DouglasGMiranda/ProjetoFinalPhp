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
            $user_id = $_SESSION['usuario']['idUsuario'];
            $descricao = $_POST['descricao'];
            $qntd = $_POST['qntd'];
            $pesoKg = $_POST['peso-kg'];
            $recebimento = $_POST['recebimento'];
            $situacao = 0; // situacao inicial
            $erros = [];

            if (empty($descricao) || strlen($descricao) > 200) {
                $erros[] = "A descrição do produto deve ter até 200 caracteres.";
            }

            if (!is_numeric($qntd) || $qntd < 1 || $qntd > 100) {
                $erros[] = "A quantidade deve ser um número entre 1 e 100.";
            }

            if (empty($pesoKg) || !is_numeric($pesoKg) || strlen($pesoKg) > 8) {
                $erros[] = "O pesoKg deve ter até 8 números.";
            }

            if (empty($recebimento) || !preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $recebimento)) {
                $erros[] = "Data de recebimento inválida. Use o formato DD/MM/AAAA.";
            } else {
                $dataRecebimentoObj = DateTime::createFromFormat('d/m/Y', $recebimento);
                $dataEntregaObj = clone $dataRecebimentoObj;
                $dataEntregaObj->modify('+7 days');
            }

            if (!empty($erros)) {
                $_SESSION['erros'] = $erros;
                header('Location: CadastroPedido');
                exit();
            } 
            else {
                // Processar o cadastro do pedido
                $pedido_id = null;
                $this->processa('C', $user_id, $pedido_id, $descricao, $qntd, $pesoKg, $dataRecebimentoObj, $dataEntregaObj, $situacao);
            }
        }
    }

    public function listarPedido() {
        $user_id = $_SESSION['usuario']['idUsuario'];
        $descricao = $qntd = $pesoKg = $dataRecebimentoObj = $dataEntregaObj = $situacao = $pedido_id = null;
        $acao = 'R';

        return $this->processa($acao, $user_id, $pedido_id, $descricao, $qntd, $pesoKg, $dataRecebimentoObj, $dataEntregaObj, $situacao);
    }

    public function atualizarPedido(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_id = null;
            $descricao = $_POST['descricao'];
            $qntd = $_POST['qntd'];
            $pesoKg = $_POST['peso-kg'];
            $recebimento = $_POST['recebimento'];
            $situacao = $_POST['situacao'];
            $erros = [];

            if (empty($descricao) || strlen($descricao) > 200) {
                $erros[] = "A descrição do produto deve ter até 200 caracteres.";
            }

            if (!is_numeric($qntd) || $qntd < 1 || $qntd > 100) {
                $erros[] = "A quantidade deve ser um número entre 1 e 100.";
            }

            if (empty($pesoKg) || !is_numeric($pesoKg) || strlen($pesoKg) > 8) {
                $erros[] = "O pesoKg deve ter até 8 números.";
            }

            if (empty($recebimento) || !preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $recebimento)) {
                $erros[] = "Data de recebimento inválida. Use o formato DD/MM/AAAA.";
            } 
            
            else {
                $dataRecebimentoObj = DateTime::createFromFormat('d/m/Y', $recebimento);
                $dataEntregaObj = clone $dataRecebimentoObj;
                $dataEntregaObj->modify('+7 days');
            }

            if (!empty($erros)) {
                $_SESSION['erros'] = $erros;
                header('Location: EditarPedido&id=' . $_POST['pedido_id']);
                exit();
            } 
            else {
                // Processar o cadastro do pedido
                $pedido_id = null;
                $this->processa('U', $user_id, $pedido_id,  $descricao, $qntd, $pesoKg, $dataRecebimentoObj, $dataEntregaObj, $situacao);
            }
        }
    }

    public function excluirPedido($id){
        $user_id = null;
        $descricao = $qntd = $pesoKg = $dataRecebimentoObj = $dataEntregaObj = $situacao = null;
        $acao = 'D';
        $pedido_id = $id;
        $this->processa($acao, $user_id, $pedido_id, $descricao, $qntd, $pesoKg, $dataRecebimentoObj, $dataEntregaObj, $situacao);
    }

    public function processa($acao, $user_id, $pedido_id, $descricao, $qntd, $pesoKg, $dataRecebimentoObj, $dataEntregaObj, $situacao){
        if($acao == 'C'){//Create
            $novoPedido = new Pedido();
            $novoPedido->setUser_id($user_id);
            $novoPedido->setDescricao($descricao);
            $novoPedido->setQntd($qntd);
            $novoPedido->setPesoKg($pesoKg);
            $novoPedido->setRecebimento($dataRecebimentoObj->format('Y-m-d'));
            $novoPedido->setEntregaLimite($dataEntregaObj->format('Y-m-d'));
            $novoPedido->setSituacao($situacao);

            $novoPedido->cadastrarPedido();
        }

        elseif ($acao == 'R') { // Read
            $permissao = $_SESSION['usuario']['permissao'];
            $pedido = new Pedido();

            if ($permissao <= 0) {
                $pedido->setUser_id($user_id);
                return $pedido->listar();
            } elseif ($permissao == 1) {
                return $pedido->listarTudo();
            }
        }

        elseif($acao == 'U'){//Update
                        $novoPedido = new Pedido();
                        $novoPedido->setPedido_id($_POST['pedido_id']);
                        $novoPedido->setDescricao($descricao);
                        $novoPedido->setQntd($qntd);
                        $novoPedido->setPesoKg($pesoKg);
                        $novoPedido->setRecebimento($dataRecebimentoObj->format('Y-m-d'));
                        $novoPedido->setEntregaLimite($dataEntregaObj->format('Y-m-d'));
                        $novoPedido->setSituacao($situacao);
        
                        $novoPedido->atualizar();
        }

        elseif($acao == 'D'){//Delete
            $novoPedido = new Pedido();
            $id = $pedido_id;
            $novoPedido->setPedido_id($id);
            $novoPedido->deletar($id);
        }
    }

    public function buscarPedido($id) {
        $Pedido = new Pedido();
        return $Pedido->buscar($id);
    }
}
?>
