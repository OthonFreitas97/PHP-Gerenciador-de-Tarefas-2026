<?php
require_once 'init.php';

verificarAcesso();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $titulo      = trim($_POST['titulo']      ?? '');
    $descricao   = trim($_POST['descricao']   ?? '');
    $responsavel = trim($_POST['responsavel'] ?? '');
    $dataVencimento  = $_POST['data_vencimento']      ?? '';
    $status      = $_POST['status']           ?? 'pendente';

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

    if (empty($dataVencimento)) {
        $erros[] = 'A data de vencimento é obrigatória.';
    }

    $status_validos = ['pendente', 'andamento', 'concluida'];
    if (!in_array($status, $status_validos)) {
        $erros[] = 'Status inválido.';
    }

    if (!empty($erros)) {
        $_SESSION['erros_tarefa'] = $erros;
        header('Location: nova_tarefa.php');
        exit;
    }
    
    $novaTarefa = [
        'id' => count($_SESSION['tarefas']) + 1,
        'titulo'      => htmlspecialchars($titulo),
        'descricao'   => htmlspecialchars($descricao),
        'responsavel' => htmlspecialchars($responsavel),
        'data_vencimento' => $dataVencimento,
        'status'      => $status,
        'usuario_id'  => $_SESSION['usuario_logado']['id'],
        'data_criacao' => date('Y-m-d H:i:s')
    ];

    $_SESSION['tarefas'][] = $novaTarefa;

    $_SESSION['sucesso_tarefa'] = 'Tarefa criada com sucesso!';
    header('Location: painel.php');
    exit;
}
?>