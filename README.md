# Lista-de-Revisao-CRUD

## Sistema de Gerenciamento de Tarefas

Este projeto implementa um sistema de gerenciamento de tarefas para uma indústria alimentícia, utilizando um modelo de kanban simples (a fazer, fazendo, pronto) com funcionalidades CRUD.

### Funcionalidades

- Cadastro de usuários
- Cadastro de tarefas associadas a usuários
- Gerenciamento de tarefas com visualização em kanban
- Atualização de status, prioridade e edição de tarefas
- Exclusão de tarefas com confirmação

### Estrutura do Banco de Dados

#### Diagrama Entidade-Relacionamento (DER)

```
users
------
id (PK)
name
email (UNIQUE)

tasks
------
id (PK)
user_id (FK -> users.id)
description
sector
priority (ENUM: baixa, media, alta)
registration_date (DEFAULT CURRENT_TIMESTAMP)
status (ENUM: a fazer, fazendo, pronto DEFAULT 'a fazer')
```

Relacionamento: Um usuário pode ter múltiplas tarefas (1:N)

#### Script de Criação do Banco

Ver arquivo `database.sql`

### Diagrama de Caso de Uso

**Atores:**
- Usuário do Sistema

**Casos de Uso:**
- Cadastrar Usuário
- Cadastrar Tarefa
- Visualizar Tarefas (Kanban)
- Editar Tarefa
- Atualizar Status da Tarefa
- Excluir Tarefa

**Fluxo Principal:**
1. Usuário acessa o menu principal
2. Usuário cadastra usuários e tarefas
3. Usuário visualiza tarefas em formato kanban
4. Usuário pode editar, atualizar status ou excluir tarefas

Nota: Os diagramas JPG devem ser criados externamente usando ferramentas como Draw.io ou Lucidchart, baseados nas descrições acima.

### Arquivos do Projeto

- `database.sql`: Script de criação do banco de dados
- `db.php`: Conexão com o banco de dados
- `index.php`: Menu principal
- `user_register.php`: Tela de cadastro de usuários
- `task_register.php`: Tela de cadastro/edição de tarefas
- `task_manage.php`: Tela de gerenciamento de tarefas (kanban)
- `style.css`: Estilos CSS
- `README.md`: Documentação

### Como Executar

1. Execute o script `database.sql` no MySQL para criar o banco de dados
2. Configure as credenciais de banco em `db.php` se necessário
3. Acesse `index.php` via servidor web (ex: XAMPP)

### Tecnologias Utilizadas

- PHP
- MySQL
- HTML/CSS
- PDO para acesso ao banco
