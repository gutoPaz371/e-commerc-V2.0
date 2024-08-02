<?php
 if($_SERVER['REQUEST_METHOD']=="POST"){
    require_once "../../config/Database.php";
    require_once "../../config/Crud.php";

    function generate_unique_token() {
        // Prefixo opcional para aumentar a unicidade do token
        $prefix = 'TOKEN';
    
        // Gerar bytes aleatórios seguros
        $random_bytes = random_bytes(32);
    
        // Converter bytes em uma representação hexadecimal
        $token = bin2hex($random_bytes);
    
        // Combinar com uniqid() para adicionar mais entropia
        $token .= uniqid();
    
        // Adicionar prefixo, se necessário
        if (!empty($prefix)) {
            $token = $prefix . '_' . $token;
        }
    
        return $token;
    }
    session_start();
    $idCliente=$_SESSION['id'];
    $idP=$_POST['idProd'];
    $v=$_POST['valor'];
    $qnt=$_POST['qnt'];

    $data = new Database();
    $db = $data->getConnection();
    $car = new Carrinho($db);
    $prod = new Produto($db);
    $res=$car->compare($idCliente,$idP);

    if($res!=null){//atualizar carrinho
        if($car->sum($res['id']))header('location: ./product-details.php?id='.$_GET['id'].'&token='.$_GET['token']);return false;
    }
    else{
        $car->id_cliente=$idCliente;
        $car->id_produto=$idP;
        $car->quantidade=$qnt;
        $car->valor=$v*$qnt;
        if($car->insert())header('location: ./product-details.php?id='.$_GET['id'].'&token='.$_GET['token']);return false;
    }    
}else echo "Servidor Offline!";