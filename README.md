# Biblioteca LMS

Sistema de gerenciamento de biblioteca (Library Management System) desenvolvido em **Laravel 12** + **PHP 8.2+**, com front-end em **Blade + Bootstrap 5**.

## Stack

| Camada      | Tecnologia                                |
|-------------|-------------------------------------------|
| Back-end    | Laravel 12 + PHP 8.2+                     |
| Banco       | MySQL (via Laravel Herd local)            |
| Servidor    | Laravel Herd / `php artisan serve`        |
| Front-end   | Blade Templates + Bootstrap 5 + Vanilla JS|
| UI / Design | Azul Escuro (`#1e293b`) + Laranja (`#f97316`) |

## Pré-requisitos

- PHP 8.2 ou superior
- Composer
- Node.js 18+ e npm
- MySQL (ou SQLite para ambiente local rápido)
- Git

---

## Como executar o projeto

Todos os comandos abaixo devem ser executados dentro da pasta `biblioteca-lms`.

```bash
cd biblioteca-lms
```

### 1. Instalar dependências

```bash
composer install
npm install
```

### 2. Configurar o ambiente

```bash
cp .env.example .env
php artisan key:generate
```

Edite o arquivo `.env` com as credenciais do banco (MySQL ou SQLite).

### 3. Rodar as migrations e seeders

```bash
php artisan migrate --seed
```

### 4. Subir o servidor

```bash
php artisan serve
```

Aplicação disponível em `http://localhost:8000`.

### 5. Compilar assets front-end

Em outro terminal:

```bash
npm run dev
```

---

## Como usar o Git

Repositório remoto: `https://github.com/keziaferretti/biblioteca-ls.git`

### Clonar o projeto

```bash
git clone https://github.com/keziaferretti/biblioteca-ls.git
cd biblioteca-ls
```

### Fluxo básico do dia a dia

```bash
# 1. Ver o status do repositório
git status

# 2. Atualizar o branch local com o remoto
git pull origin main

# 3. Criar um novo branch para sua tarefa
git checkout -b feat/nome-da-feature

# 4. Adicionar arquivos modificados
git add .

# 5. Criar um commit
git commit -m "feat: descrição curta da mudança"

# 6. Enviar o branch para o repositório remoto
git push -u origin feat/nome-da-feature
```

### Padrão de mensagens de commit

| Prefixo    | Quando usar                                |
|------------|--------------------------------------------|
| `feat:`    | Nova funcionalidade                        |
| `fix:`     | Correção de bug                            |
| `refactor:`| Refatoração sem alterar comportamento      |
| `docs:`    | Apenas documentação                        |
| `style:`   | Formatação, espaços, ponto-e-vírgula       |
| `test:`    | Adição ou ajuste de testes                 |
| `chore:`   | Tarefas de build, dependências, configs    |

### Comandos úteis

```bash
# Ver histórico resumido
git log --oneline --graph --decorate

# Trocar de branch
git checkout main

# Desfazer alterações em um arquivo (não commitado)
git checkout -- caminho/arquivo

# Atualizar seu branch com a main mais recente
git checkout main
git pull
git checkout seu-branch
git merge main
```

### Abrir um Pull Request

1. Faça `push` do seu branch.
2. Acesse o repositório no GitHub.
3. Clique em **Compare & pull request**.
4. Preencha título e descrição seguindo o padrão de commits.
5. Solicite revisão e aguarde o merge.

---

## Estrutura do projeto

```
project_test/
├── README.md                ← este arquivo
└── biblioteca-lms/          ← aplicação Laravel
    ├── app/
    ├── bootstrap/
    ├── config/
    ├── database/
    ├── public/
    ├── resources/
    ├── routes/
    ├── storage/
    ├── tests/
    ├── CLAUDE.md            ← diretrizes de arquitetura
    └── README.md            ← README padrão do Laravel
```

Consulte `biblioteca-lms/CLAUDE.md` para as diretrizes de arquitetura, padrões de código e checklist por entidade.