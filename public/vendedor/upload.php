<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['files'])) {
        $files = $_FILES['files'];
        
        // Verifique se houve algum erro no upload dos arquivos
        if ($files['error'][0] == UPLOAD_ERR_OK) {
            $uploadDirectory = 'uploads/';

            // Crie o diretório de upload se não existir
            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true);
            }

            $totalFiles = count($files['name']);

            for ($i = 0; $i < $totalFiles; $i++) {
                // Verifique se não houve erro para cada arquivo individualmente
                if ($files['error'][$i] == UPLOAD_ERR_OK) {
                    $fileName = basename($files['name'][$i]);
                    $targetFilePath = $uploadDirectory . $fileName;

                    // Move o arquivo para o diretório de upload
                    if (move_uploaded_file($files['tmp_name'][$i], $targetFilePath)) {
                        echo "O arquivo " . $fileName . " foi enviado com sucesso.<br>";
                    } else {
                        echo "Erro ao enviar o arquivo " . $fileName . ".<br>";
                    }
                } else {
                    echo "Erro ao enviar o arquivo " . $files['name'][$i] . ". Código de erro: " . $files['error'][$i] . "<br>";
                }
            }
        } else {
            echo "Erro ao enviar os arquivos. Código de erro: " . $files['error'][0] . "<br>";
        }
    } else {
        echo "Nenhum arquivo enviado.<br>";
    }
} else {
    echo "Método de solicitação inválido.";
}
?>
