<?php
include 'db.php';

try {
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT NOT NULL UNIQUE
        );

        CREATE TABLE IF NOT EXISTS tasks (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            description TEXT NOT NULL,
            sector TEXT NOT NULL,
            priority TEXT CHECK(priority IN ('baixa', 'media', 'alta')) NOT NULL,
            registration_date DATETIME DEFAULT CURRENT_TIMESTAMP,
            status TEXT CHECK(status IN ('a fazer', 'fazendo', 'pronto')) DEFAULT 'a fazer',
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        );
    ");
    echo "Database initialized successfully.";
} catch (PDOException $e) {
    echo "Error initializing database: " . $e->getMessage();
}
?>
