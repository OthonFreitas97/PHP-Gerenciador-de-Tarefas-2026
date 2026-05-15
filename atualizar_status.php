<?php
require_once 'init.php';

verificarAcesso();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // 1. Recebe os dados com segurança
    $titulo          = trim($_POST['titulo'] ?? '');
    $descricao       = trim($_POST['descricao'] ?? '');
    $responsavel     = trim($_POST['responsavel'] ?? '');
    $data_vencimento = $_POST['data_vencimento'] ?? '';
    $status          = $_POST['status'] ?? 'pendente';

    $erros = [];
    if (empty($titulo)) $erros[] = 'O título é obrigatório.';
    if (empty($descricao)) $erros[] = 'A descrição é obrigatória.';
    if (empty($responsavel)) $erros[] = 'O responsável é obrigatório.';
    if (empty($data_vencimento)) $erros[] = 'A data de vencimento é obrigatória.';

    if (!empty($erros)) {
        $_SESSION['erros_tarefa'] = $erros;
        header('Location: nova_tarefa.php');
        exit;
    }

    $novaTarefa = [
        'id'              => count($_SESSION['tarefas']) + 1, 
        'titulo'          => htmlspecialchars($titulo),
        'descricao'       => htmlspecialchars($descricao),
        'responsavel'     => htmlspecialchars($responsavel),
        'data_vencimento' => $data_vencimento,
        'status'          => $status,
        'usuario_id'      => $_SESSION['usuario_logado']['id'],
        'criador'         => $_SESSION['usuario_logado']['nome'],
        'comentarios'     => [],
        'historico'       => [
            [
                'descricao' => 'Tarefa criada com status inicial: ' . ucfirst($status),
                'usuario'   => $_SESSION['usuario_logado']['nome'],
                'data'      => date('d/m/Y H:i:s')
            ]
        ]
    ];

    $_SESSION['tarefas'][] = $novaTarefa;

    header('Location: painel.php');
    exit;
}

header('Location: nova_tarefa.php');
exit;
?>