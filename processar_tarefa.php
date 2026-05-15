<?php
require_once 'init.php';

verificarAcesso();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $responsavel = $_POST['responsavel'];
    $data_vencimento = $_POST['data_vencimento'];
    $status = $_POST['status'];

    $novaTarefa = [
        'titulo' => $titulo,
        'descricao' => $descricao,
        'responsavel' => $responsavel,
        'data_vencimento' => $data_vencimento,
        'status' => $status,
        'criador' => $_SESSION['usuario_logado']['nome'],
        'comentarios' => [],
        'historico' => [
            [
                'descricao' => 'Tarefa criada',
                'usuario' => $_SESSION['usuario_logado']['nome'],
                'data' => date('d/m/Y H:i')
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