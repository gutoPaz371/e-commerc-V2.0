<?php



// Define o caminho do arquivo onde os dados serão salvos
$arquivo = 'dados_recebidos.txt';

// Verifica se o método de requisição é POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtém o conteúdo do corpo da requisição
    $json = file_get_contents('php://input');
    
    // Decodifica o JSON em um array associativo
    $dados = json_decode($json, true);
    
    // Verifica se a decodificação foi bem-sucedida
    if (json_last_error() === JSON_ERROR_NONE) {
        // Converte o array de volta para uma string JSON formatada
        $jsonFormatado = json_encode($dados, JSON_PRETTY_PRINT);
        
        // Salva os dados no arquivo
        file_put_contents($arquivo, $jsonFormatado . PHP_EOL, FILE_APPEND);
        
        // Retorna uma resposta de sucesso
        http_response_code(200);
        echo json_encode(["mensagem" => "Dados recebidos e salvos com sucesso."]);
    } else {
        // Retorna uma resposta de erro
        http_response_code(400);
        echo json_encode(["mensagem" => "Erro ao decodificar JSON."]);
    }
} else {
    // Retorna uma resposta de erro se o método não for POST
    http_response_code(405);
    echo json_encode(["mensagem" => "Método não permitido. Use POST."]);
}
?>
