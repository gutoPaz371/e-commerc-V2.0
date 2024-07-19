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
    
    $idCliente=2;
    $idP=$_POST['idProd'];
    $v=$_POST['valor'];
    $qnt=$_POST['qnt'];

    $data = new Database();
    $db = $data->getConnection();
    $car = new Carrinho($db);
    $prod = new Produto($db);
    $res=$car->compare($idCliente,$idP);

    if($res!=null){//atualizar carrinho
        echo "atualizar carrinho";
        var_dump($res);
        $car->id=$res['id'];
        $car->quantidade=intval($res['quantidade'])+$qnt;
        $car->valor=(intval(str_replace(",",".",$res['valor']))/$res['quantidade'])*$car->quantidade;
        if($car->update())header('location: ./product-details.php');return false;
    }
    
    else{
        $car->id_cliente=$idCliente;
        $car->id_produto=$idP;
        $car->valor=$v;
        $car->quantidade=$qnt;
        $car->insert();


    }
       
    
}else echo "Servidor Offline!";