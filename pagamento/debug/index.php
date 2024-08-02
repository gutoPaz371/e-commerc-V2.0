<?php
// Verifica se o parâmetro 'data' foi passado via GET
if (isset($_GET['data'])) {
    // Pega o valor do parâmetro 'data'
    $data = $_GET['data'];

    // Nome do arquivo onde os dados serão escritos
    $file = 'data.txt';

    // Abre o arquivo para escrita (append mode)
    $handle = fopen($file, 'a');

    // Verifica se o arquivo foi aberto com sucesso
    if ($handle) {
        // Escreve os dados no arquivo com uma nova linha
        fwrite($handle, $data . PHP_EOL);

        // Fecha o arquivo
        fclose($handle);

        // Responde ao usuário que a operação foi bem-sucedida
        echo "Dados escritos no arquivo com sucesso!";
    } else {
        // Responde ao usuário em caso de erro ao abrir o arquivo
        echo "Não foi possível abrir o arquivo para escrita.";
    }
} else {
    // Responde ao usuário em caso de ausência do parâmetro 'data'
    echo "Nenhum dado recebido para escrever no arquivo.";
}
?>
