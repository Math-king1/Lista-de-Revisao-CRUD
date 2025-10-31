<?php
include 'db.php';

$message = '';
$edit_task = null;

if (isset($_GET['edit'])) {
    $task_id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ?");
    $stmt->execute([$task_id]);
    $edit_task = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $description = trim($_POST['description']);
    $sector = trim($_POST['sector']);
    $priority = $_POST['priority'];

    if (!empty($user_id) && !empty($description) && !empty($sector) && !empty($priority)) {
        if ($edit_task) {
            $stmt = $pdo->prepare("UPDATE tasks SET user_id = ?, description = ?, sector = ?, priority = ? WHERE id = ?");
            if ($stmt->execute([$user_id, $description, $sector, $priority, $edit_task['id']])) {
                $message = 'Tarefa atualizada com sucesso';
            } else {
                $message = 'Erro ao atualizar tarefa';
            }
        } else {
            $stmt = $pdo->prepare("INSERT INTO tasks (user_id, description, sector, priority) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$user_id, $description, $sector, $priority])) {
                $message = 'Tarefa cadastrada com sucesso';
            } else {
                $message = 'Erro ao cadastrar tarefa';
            }
        }
    } else {
        $message = 'Todos os campos são obrigatórios';
    }
}


$users = $pdo->query("SELECT id, name FROM users")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Tarefa</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h1><?php echo $edit_task ? 'Editar Tarefa' : 'Cadastrar Tarefa'; ?></h1>
    <form method="POST">
        <label for="user_id">Usuário:</label>
        <select id="user_id" name="user_id" required>
            <option value="">Selecione um usuário</option>
            <?php foreach ($users as $user): ?>
                <option value="<?php echo $user['id']; ?>" <?php echo ($edit_task && $edit_task['user_id'] == $user['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($user['name']); ?></option>
            <?php endforeach; ?>
        </select><br><br>
        <label for="description">Descrição:</label>
        <textarea id="description" name="description" required><?php echo $edit_task ? htmlspecialchars($edit_task['description']) : ''; ?></textarea><br><br>
        <label for="sector">Setor:</label>
        <input type="text" id="sector" name="sector" value="<?php echo $edit_task ? htmlspecialchars($edit_task['sector']) : ''; ?>" required><br><br>
        <label for="priority">Prioridade:</label>
        <select id="priority" name="priority" required>
            <option value="baixa" <?php echo ($edit_task && $edit_task['priority'] == 'baixa') ? 'selected' : ''; ?>>Baixa</option>
            <option value="media" <?php echo ($edit_task && $edit_task['priority'] == 'media') ? 'selected' : ''; ?>>Média</option>
            <option value="alta" <?php echo ($edit_task && $edit_task['priority'] == 'alta') ? 'selected' : ''; ?>>Alta</option>
        </select><br><br>
        <button type="submit"><?php echo $edit_task ? 'Atualizar' : 'Cadastrar'; ?></button>
    </form>
    <?php if ($message): ?>
        <p class="message <?php echo strpos($message, 'Erro') === false ? 'success' : 'error'; ?>"><?php echo $message; ?></p>
    <?php endif; ?>
    <a href="index.php" class="back-link">Voltar ao Menu</a>
</body>
</html>
