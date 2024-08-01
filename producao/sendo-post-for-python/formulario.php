<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Formulário de Envio</title>
</head>
<body>
    <form action="processar.php" method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email">
        <button type="submit">Enviar</button>
    </form>
</body>
</html>
