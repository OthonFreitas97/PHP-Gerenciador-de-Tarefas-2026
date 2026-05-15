Othon Augusto Freitas Nascimento 
RGM: 41606124

Pedro Henrique Becker De Oliveira Felix 
RGM: 41805640

Brayan Matheus de Godoi Santos
RGM: 41964772

Julia Helena Buosi Teixeira 
RGM: 44061919

Walter Potma de Brito 
RGM: 43101607

Victor Hugo Ribeiro da Silva 
RGM: 42520959

# Gerenciador de Tarefas - PHP

Um projeto simples de gerenciamento de tarefas desenvolvido em PHP com HTML e CSS. Ideal para aprender PHP básico!

## 📁 Estrutura do Projeto

```
projeto/
├── model/              # Classes do projeto
│   ├── Usuario.php     # Classe Usuario
│   └── Tarefa.php      # Classe Tarefa
├── view/               # Páginas
│   ├── 404.php         # Erro não encontrado
│   └── home.php        # Página inicial
├── assets/             # Estilos
│   └── style.css       # CSS do projeto
├── index.php           # Página de login
├── cadastro.php        # Página de cadastro
├── painel.php          # Painel com tarefas
├── nova_tarefa.php     # Criar nova tarefa
├── detalhes_tarefa.php # Ver detalhes
├── processar_login.php # Processa login
├── processar_cadastro.php # Processa cadastro
├── processar_tarefa.php # Processa tarefa
├── logout.php          # Sair do sistema
├── init.php            # Inicialização
├── menu.php            # Menu
└── README.md           # Esta documentação
```

## 🚀 Como Usar

### 1. Inicie o servidor PHP
```bash
php -S localhost:8000
```

### 2. Abra no navegador
```
http://localhost:8000/index.php
```

### 3. Crie uma conta
- Clique em "Cadastre-se"
- Preencha: Nome, Email, Senha
- Clique em "Cadastrar"

### 4. Faça Login
- Insira Email e Senha
- Clique em "Entrar"

### 5. Crie Tarefas
- No Painel, clique em "Nova Tarefa"
- Preencha os dados
- Clique em "Criar Tarefa"

## 📚 Classes Principais

### Classe Usuario

```php
$usuario = new Usuario($id, $nome, $email, $senha);

// Métodos disponíveis:
$usuario->validar();    // Valida os dados
$usuario->toString();   // Retorna como texto
```

**Atributos:**
- `$id` - Identificador único
- `$nome` - Nome do usuário
- `$email` - Email (precisa ser válido)
- `$senha` - Senha (mínimo 6 caracteres)

### Classe Tarefa

```php
$tarefa = new Tarefa($id, $titulo, $descricao, $status, $responsavel, $data_vencimento, $usuario_id);

// Métodos disponíveis:
$tarefa->validar();     // Valida os dados
$tarefa->toString();    // Retorna como texto
```

**Atributos:**
- `$id` - Identificador único
- `$titulo` - Título da tarefa
- `$descricao` - Descrição
- `$status` - Status (pendente, andamento, concluida)
- `$responsavel` - Quem vai fazer
- `$data_vencimento` - Quando termina
- `$usuario_id` - Quem criou

## 🔐 Funcionalidades

✅ Cadastro de usuários  
✅ Login com segurança  
✅ Criar tarefas  
✅ Visualizar tarefas  
✅ Filtrar por status  
✅ Filtrar por responsável  
✅ Logout  

## 💾 Dados

Os dados são armazenados na **sessão PHP** (`$_SESSION`) durante o uso. 

```php
// Usuários
$_SESSION['usuarios'] = [
    ['id' => 1, 'nome' => 'João', 'email' => 'joao@email.com', 'senha' => 'hash...'],
    ...
];

// Tarefas
$_SESSION['tarefas'] = [
    ['id' => 1, 'titulo' => 'Fazer...', 'status' => 'pendente', ...],
    ...
];
```

**Importante:** Ao fechar o navegador, os dados serão perdidos. Para usar um banco de dados permanente, você precisaria integrar com MySQL.

## 🔒 Segurança

✅ Senhas criptografadas com `password_hash()`  
✅ Validação de entrada com `htmlspecialchars()`  
✅ Validação de email com `filter_var()`  
✅ Verificação de login em cada página  

## 🎨 Estilos

O projeto usa CSS em `assets/style.css` com:
- Design responsivo
- Cores padronizadas
- Componentes reutilizáveis

## 📝 Exemplos de Código

### Cadastrar Usuário

```php
// Criar um novo usuário
$novoUsuario = [
    'id' => count($_SESSION['usuarios']) + 1,
    'nome'  => htmlspecialchars($nome),
    'email' => htmlspecialchars($email),
    'senha' => password_hash($senha, PASSWORD_DEFAULT)
];

// Salvar na sessão
$_SESSION['usuarios'][] = $novoUsuario;
```

### Criar Tarefa

```php
// Criar uma nova tarefa
$novaTarefa = [
    'id' => count($_SESSION['tarefas']) + 1,
    'titulo'      => htmlspecialchars($titulo),
    'descricao'   => htmlspecialchars($descricao),
    'responsavel' => htmlspecialchars($responsavel),
    'data_vencimento' => $dataVencimento,
    'status'      => 'pendente',
    'usuario_id'  => $_SESSION['usuario_logado']['id'],
    'data_criacao' => date('Y-m-d H:i:s')
];

// Salvar na sessão
$_SESSION['tarefas'][] = $novaTarefa;
```

### Fazer Login

```php
// Procurar o usuário
$usuario_encontrado = null;
foreach ($_SESSION['usuarios'] as $u) {
    if ($u['email'] === $email) {
        $usuario_encontrado = $u;
        break;
    }
}

// Verificar senha
if ($usuario_encontrado && password_verify($senha, $usuario_encontrado['senha'])) {
    $_SESSION['usuario_logado'] = $usuario_encontrado;
    header('Location: painel.php');
}
```

## 🔄 Fluxo do Projeto

```
1. Usuario acessa index.php (Login)
   ↓
2. Se não tem conta, vai para cadastro.php
   ↓
3. Preenche formulário e vai para processar_cadastro.php
   ↓
4. Dados são salvos em $_SESSION['usuarios']
   ↓
5. Volta para login e faz login
   ↓
6. Vai para painel.php (lista as tarefas)
   ↓
7. Clica em "Nova Tarefa"
   ↓
8. Preenche formulário em nova_tarefa.php
   ↓
9. Vai para processar_tarefa.php
   ↓
10. Dados são salvos em $_SESSION['tarefas']
    ↓
11. Volta para painel.php com a nova tarefa
```

## 📋 Estrutura de Dados

### Um Usuário

```php
[
    'id'    => 1,
    'nome'  => 'João Silva',
    'email' => 'joao@email.com',
    'senha' => '$2y$10$abcd...xyz' // Hash da senha
]
```

### Uma Tarefa

```php
[
    'id'              => 1,
    'titulo'          => 'Fazer relatório',
    'descricao'       => 'Relatório de vendas',
    'responsavel'     => 'João',
    'status'          => 'pendente',
    'usuario_id'      => 1,
    'data_criacao'    => '2026-05-15 10:30:00',
    'data_vencimento' => '2026-05-20'
]
```

## 🆘 Troubleshooting

| Erro | Solução |
|------|---------|
| Headers already sent | Remova espaços antes de `<?php` |
| Class not found | Verifique se o arquivo está em `/model/` |
| Dados perdidos | Dados de SESSION são perdidos ao fechar o navegador |
| Erro de validação | Verifique se email é válido e senha tem 6+ caracteres |

## 🎓 Conceitos Aprendidos

✅ Variáveis e tipos de dados  
✅ Operadores e condições  
✅ Arrays e loops  
✅ Funções e métodos  
✅ Classes e objetos  
✅ SESSION e cookies  
✅ Formulários  
✅ Validação de dados  
✅ Criptografia de senhas  
✅ Redirecionamento  

## 📖 Dúvidas?

Consulte os comentários no código. Cada arquivo tem explicações claras sobre o que faz.

**Arquivos mais importantes:**
- `init.php` - Entender como o projeto começa
- `processar_cadastro.php` - Como guardar dados
- `processar_login.php` - Como verificar login
- `painel.php` - Como listar e filtrar

---

**Versão**: 2.0  
**Status**: Pronto para usar ✅  
**Nível**: Iniciante - Estudante
