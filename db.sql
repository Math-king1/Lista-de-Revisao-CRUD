PRAGMA foreign_keys = ON;


CREATE TABLE users (
id INTEGER PRIMARY KEY AUTOINCREMENT,
name VARCHAR(255) NOT NULL,
email VARCHAR(255) NOT NULL UNIQUE
);


CREATE TABLE tasks (
id INTEGER PRIMARY KEY AUTOINCREMENT,
user_id INTEGER NOT NULL,
description TEXT NOT NULL,
sector VARCHAR(100) NOT NULL,
priority VARCHAR(10) NOT NULL CHECK (priority IN ('baixa','media','alta')),
created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
status VARCHAR(10) NOT NULL CHECK (status IN ('a fazer','fazendo','pronto')),
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);



INSERT INTO users (name, email) VALUES ('João Silva', 'joao@example.com');
INSERT INTO users (name, email) VALUES ('Maria Souza', 'maria@example.com');


INSERT INTO tasks (user_id, description, sector, priority, status) VALUES (1, 'Limpar linha de envase', 'Produção', 'alta', 'a fazer');
INSERT INTO tasks (user_id, description, sector, priority, status) VALUES (2,'Revisar estoque de embalagens', 'Logística', 'media', 'a fazer');