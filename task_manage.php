<?php
include 'db.php';

// Handle status update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $task_id = $_POST['task_id'];
    $new_status = $_POST['status'];
    $stmt = $pdo->prepare("UPDATE tasks SET status = ? WHERE id = ?");
    $stmt->execute([$new_status, $task_id]);
}

// Handle delete
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $task_id = $_POST['task_id'];
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->execute([$task_id]);
}

// Fetch tasks grouped by status
$tasks = $pdo->query("SELECT t.*, u.name as user_name FROM tasks t JOIN users u ON t.user_id = u.id ORDER BY t.registration_date DESC")->fetchAll(PDO::FETCH_ASSOC);

$grouped_tasks = [
    'a fazer' => [],
    'fazendo' => [],
    'pronto' => []
];

foreach ($tasks as $task) {
    $grouped_tasks[$task['status']][] = $task;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Tarefas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Gerenciar Tarefas</h1>
    <div class="kanban">
        <div class="column">
            <h2>A Fazer</h2>
            <?php foreach ($grouped_tasks['a fazer'] as $task): ?>
                <div class="task">
                    <p><strong>Descrição:</strong> <?php echo htmlspecialchars($task['description']); ?></p>
                    <p><strong>Setor:</strong> <?php echo htmlspecialchars($task['sector']); ?></p>
                    <p><strong>Prioridade:</strong> <?php echo htmlspecialchars($task['priority']); ?></p>
                    <p><strong>Usuário:</strong> <?php echo htmlspecialchars($task['user_name']); ?></p>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                        <select name="status">
                            <option value="a fazer" selected>A Fazer</option>
                            <option value="fazendo">Fazendo</option>
                            <option value="pronto">Pronto</option>
                        </select>
                        <button type="submit" name="update_status">Atualizar Status</button>
                    </form>
                    <a href="task_register.php?edit=<?php echo $task['id']; ?>">Editar</a>
                    <form method="POST" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir?')">
                        <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                        <button type="submit" name="delete">Excluir</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="column">
            <h2>Fazendo</h2>
            <?php foreach ($grouped_tasks['fazendo'] as $task): ?>
                <div class="task">
                    <p><strong>Descrição:</strong> <?php echo htmlspecialchars($task['description']); ?></p>
                    <p><strong>Setor:</strong> <?php echo htmlspecialchars($task['sector']); ?></p>
                    <p><strong>Prioridade:</strong> <?php echo htmlspecialchars($task['priority']); ?></p>
                    <p><strong>Usuário:</strong> <?php echo htmlspecialchars($task['user_name']); ?></p>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                        <select name="status">
                            <option value="a fazer">A Fazer</option>
                            <option value="fazendo" selected>Fazendo</option>
                            <option value="pronto">Pronto</option>
                        </select>
                        <button type="submit" name="update_status">Atualizar Status</button>
                    </form>
                    <a href="task_register.php?edit=<?php echo $task['id']; ?>">Editar</a>
                    <form method="POST" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir?')">
                        <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                        <button type="submit" name="delete">Excluir</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="column">
            <h2>Pronto</h2>
            <?php foreach ($grouped_tasks['pronto'] as $task): ?>
                <div class="task">
                    <p><strong>Descrição:</strong> <?php echo htmlspecialchars($task['description']); ?></p>
                    <p><strong>Setor:</strong> <?php echo htmlspecialchars($task['sector']); ?></p>
                    <p><strong>Prioridade:</strong> <?php echo htmlspecialchars($task['priority']); ?></p>
                    <p><strong>Usuário:</strong> <?php echo htmlspecialchars($task['user_name']); ?></p>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                        <select name="status">
                            <option value="a fazer">A Fazer</option>
                            <option value="fazendo">Fazendo</option>
                            <option value="pronto" selected>Pronto</option>
                        </select>
                        <button type="submit" name="update_status">Atualizar Status</button>
                    </form>
                    <a href="task_register.php?edit=<?php echo $task['id']; ?>">Editar</a>
                    <form method="POST" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir?')">
                        <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                        <button type="submit" name="delete">Excluir</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <a href="index.php">Voltar ao Menu</a>
</body>
</html>
