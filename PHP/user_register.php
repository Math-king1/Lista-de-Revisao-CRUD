<?php
include 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

    if (!empty($name) && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        if ($stmt->execute([$name, $email])) {
            $message = 'Cadastro concluído com sucesso';
        } else {
            $message = 'Erro ao cadastrar usuário';
        }
    } else {
        $message = 'Todos os campos são obrigatórios e o e-mail deve ser válido';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Usuário</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Cadastrar Usuário</h1>
    <form method="POST">
        <label for="name">Nome:</label>
        <input type="text" id="name" name="name" required><br><br>
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required><br><br>
        <button type="submit">Cadastrar</button>
    </form>
    <?php if ($message): ?>
        <p class="message <?php echo strpos($message, 'Erro') === false ? 'success' : 'error'; ?>"><?php echo $message; ?></p>
    <?php endif; ?>
    <a href="index.php" class="back-link">Voltar ao Menu</a>
</body>
</html>
