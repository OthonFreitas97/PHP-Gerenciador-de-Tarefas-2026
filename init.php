<?php
// 1. Inicia ou recupera a sessão existente
// Sem isso, a variável $_SESSION não funciona.
session_start();

// 2. Inicializa o "Banco de Dados" simulado (Requisito 14)
// Verificamos se as chaves já existem. Se não, criamos arrays vazios.
if (!isset($_SESSION['usuarios'])) {
    $_SESSION['usuarios'] = [];
}

if (!isset($_SESSION['tarefas'])) {
    $_SESSION['tarefas'] = [];
}

// 3. Configurações de fuso horário (Opcional, mas boa prática para logs)
date_default_timezone_set('America/Sao_Paulo');

// 4. (Opcional) Função auxiliar para verificar login em páginas protegidas
function verificarAcesso() {
    if (!isset($_SESSION['usuario_logado'])) {
        header('Location: index.php');
        exit;
    }
}
?>