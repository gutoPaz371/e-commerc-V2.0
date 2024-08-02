<?php
// var_dump($_POST);
// Os dados que você deseja enviar via POST
$data = array("argumento" => "Teste");

// Transforme os dados em uma string JSON
$data_string = json_encode($data);

// Inicialize o cURL
$ch = curl_init('http://localhost:5000/process');

// Configure as opções do cURL
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_string))
);

// Execute a solicitação e obtenha a resposta
$result = curl_exec($ch);

// Feche o cURL
curl_close($ch);

// Exiba a resposta do servidor Python
echo $result;
?>
