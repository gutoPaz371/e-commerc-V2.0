<?php
if($_SERVER['REQUEST_METHOD']==='POST'){
    $nome = $_POST['nome'];

    $data = array(
        'nome' => $nome,
    );

    $url = 'http://localhost:5000/api';

    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        echo "Erro ao enviar os dados para o script Python.";
    } else {
        echo "Dados enviados com sucesso.";
    }
}
    echo $_POST['variable_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Detalher da compra Compra</h1>
    <form action="#" method="post">
        <label for="Produto"></label>
        <input type="text" name="nome" value="Camisa" >
        <label for="">Valor</label>
        <input type="" name="valor" value="50" >
        <label for="">Quantidade</label>
        <input type="" name="qnt" value="3">
        <button type="submit">Enviar</button>
    </form>
</body>
</html>