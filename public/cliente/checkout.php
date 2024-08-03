<?php
if(true){//sem endereço
    header("location: registrarEndereco.html");
}
$dados=json_decode($_POST['dados-json']);
$valor_total=$dados[count($dados)-1]->resume->{'valor-total'};
$qnt_total=$dados[count($dados)-1]->resume->{'qnt-total'};
$data = [];
foreach($dados as $row){
    if (isset($row->itens)) {
        // echo 'ID: ' . $row->itens->id . "\n";
        array_push($data,array(
            'id'            => $row->itens->id,
            'title'         => $row->itens->nome,
            'quantity'      => $row->itens->qnt,
            'currency_id'   => "BRL",
            'unit_price'    => $row->itens->valor/$row->itens->qnt
        ));
    }
}
// echo "QNT: $qnt_total\nVALOR TOTAL: $valor_total";

// Os dados que você deseja enviar via POST

// Transforme os dados em uma string JSON
$data_string = json_encode($data);

// Inicialize o cURL
$ch = curl_init('http://localhost:5000/');

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
