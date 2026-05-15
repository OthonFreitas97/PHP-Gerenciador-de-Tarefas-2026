<?php
require_once 'init.php';

// Verifica se o usuário está logado
verificarAcesso();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $titulo      = trim($_POST['titulo']      ?? '');
    $descricao   = trim($_POST['descricao']   ?? '');
    $responsavel = trim($_POST['responsavel'] ?? '');
    $dataLimite  = $_POST['data_limite']      ?? '';
    $status      = $_POST['status']           ?? 'Pendente';

    // --- Validações ---
    $erros = [];

    if (empty($titulo)) {
        $erros[] = 'O título é obrigatório.';
    }

    if (empty($descricao)) {
        $erros[] = 'A descrição é obrigatória.';
    }

    if (empty($responsavel)) {
        $erros[] = 'O responsável é obrigatório.';
    }

    if (empty($dataLimite)) {
        $erros[] = 'A data limite é obrigatória.';
    }

    $status_validos = ['Pendente', 'Em andamento', 'Concluída'];
    if (!in_array($status, $status_validos)) {
        $erros[] = 'Status inválido.';
    }

    // Se houver erros, volta para o formulário com as mensagens
    if (!empty($erros)) {
        $_SESSION['erros_tarefa'] = $erros;
        header('Location: nova_tarefa.php');
        exit;
    }
    
    // --- Salva a tarefa na sessão ---
    $novaTarefa = [
        'titulo'      => htmlspecialchars($titulo),
        'descricao'   => htmlspecialchars($descricao),
        'responsavel' => htmlspecialchars($responsavel),
        'data_limite' => $dataLimite,
        'status'      => $status,
        'criado_por'  => $_SESSION['usuario_logado']['nome'],
        'criado_em'   => date('d/m/Y H:i'),
        'historico'   => [
            [
                'acao'      => 'Tarefa criada',
                'usuario'   => $_SESSION['usuario_logado']['nome'],
                'data_hora' => date('d/m/Y H:i')
            ]
        ]
    ];

    $_SESSION['tarefas'][] = $novaTarefa;

    $_SESSION['sucesso_tarefa'] = 'Tarefa criada com sucesso!';
    header('Location: painel.php');
    exit;
}
?>