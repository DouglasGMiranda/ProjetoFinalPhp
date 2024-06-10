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
                $this->processa('C', $user_id, $descricao, $qntd, $pesoKg, $dataRecebimentoObj, $dataEntregaObj, $situacao);
            }
        }
    }

    public function processa($acao, $user_id, $descricao, $qntd, $pesoKg, $dataRecebimentoObj, $dataEntregaObj, $situacao){
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

        elseif($acao == 'R'){//Read

            $permissao = $_SESSION['usuario']['permissao'];
          
            if($permissao <= 0){

                $pedido = new Pedido();
                $pedido->setUser_id($user_id);
                $pedido->listar();
            }

            elseif($permissao == 1){
                $pedido = new Pedido();
                $pedido->listarTudo();
            }
        }

        elseif($acao == 'U'){//Update
            $permissao = $_SESSION['usuario']['permissao'];

            if($permissao < 1){
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $pedido_id = $_POST['pedido_id']; 
                    $descricao = $_POST['descricao'];
                    $qntd = $_POST['qntd'];
                    $pesoKg = $_POST['pesoKg'];
        
                    $erros = [];
        
                    if (empty($descricao) || strlen($descricao) > 200) {
                        $erros[] = "A descrição do produto deve ter até 200 caracteres.";
                    }
        
                    if (!is_numeric($qntd) || $qntd < 1 || $qntd > 100) {
                        $erros[] = "A qntd deve ser um número entre 1 e 100.";
                    }
        
                    if (empty($pesoKg) || strlen($pesoKg) > 8) {
                        $erros[] = "O pesoKg deve ter até 8 caracteres.";
                    }
        
                    if (!empty($erros)) {
                        $_SESSION['erros'] = $erros;
                        header("Location: EditarPedido?id=$pedido_id");
                        exit();
                    } 
                    
                    else {
                        $novoPedido = new Pedido();
                        $novoPedido->setPedido_id($pedido_id);
                        $novoPedido->setDescricao($descricao);
                        $novoPedido->setQntd($qntd);
                        $novoPedido->setPesoKg($pesoKg);
                        $novoPedido->setRecebimento($dataRecebimentoObj->format('Y-m-d'));
                        $novoPedido->setEntregaLimite($dataEntregaObj->format('Y-m-d'));
                        $novoPedido->setSituacao($situacao);
        
                        $novoPedido->atualizar();
                        header('Location: ListaPedido');
                    }
                }
            }
        }
    }

    public function listarPedido() {
        $Pedido = new Pedido();
        $Pedido->setUser_id($_SESSION['usuario']['idUsuario']);
        return $Pedido->listar();
    }

    public function buscarPedido($id) {
        $Pedido = new Pedido();
        return $Pedido->buscar($id);
    }

    public function atualizarPedido() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $pedido_id = $_POST['pedido_id'];
            $descricao = $_POST['descricao'];
            $qntd = $_POST['qntd'];
            $pesoKg = $_POST['pesoKg'];
            $recebimento = $_POST['recebimento'];
            $situacao = $_POST['situacao'];

            $dataRecebimentoObj = DateTime::createFromFormat('d/m/Y', $recebimento);
            $dataEntregaObj = clone $dataRecebimentoObj;
            $dataEntregaObj->modify('+7 days');

            $erros = [];

            if (empty($descricao) || strlen($descricao) > 200) {
                $erros[] = "A descrição do produto deve ter até 200 caracteres.";
            }

            if (!is_numeric($qntd) || $qntd < 1 || $qntd > 100) {
                $erros[] = "A qntd deve ser um número entre 1 e 100.";
            }

            if (empty($pesoKg) || strlen($pesoKg) > 8) {
                $erros[] = "O pesoKg deve ter até 8 caracteres.";
            }

            if (empty($recebimento) || !preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $recebimento)) {
                $erros[] = "Data de recebimento inválida. Use o formato DD/MM/AAAA.";
            }

            if (!empty($erros)) {
                $_SESSION['erros'] = $erros;
                header("Location: EditarPedido?id=$pedido_id");
                exit();
            } else {
                $novoPedido = new Pedido();
                $novoPedido->setPedido_id($pedido_id);
                $novoPedido->setDescricao($descricao);
                $novoPedido->setQntd($qntd);
                $novoPedido->setPesoKg($pesoKg);
                $novoPedido->setRecebimento($dataRecebimentoObj->format('Y-m-d'));
                $novoPedido->setEntregaLimite($dataEntregaObj->format('Y-m-d'));
                $novoPedido->setSituacao($situacao);

                $novoPedido->atualizar();
                header('Location: ListaPedido');
            }
        }
    }

    public function deletarPedido($id) {
        $novoPedido = new Pedido();
        $novoPedido->deletar($id);
        header('Location: ListaPedido');
    }
}
?>
