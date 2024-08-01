<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    $data = array(
        'nome' => $nome,
        'email' => $email
    );

    $url = 'http://localhost:5000/processar';

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
?>
