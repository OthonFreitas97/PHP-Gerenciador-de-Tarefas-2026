<?php
require_once 'init.php';

verificarAcesso();

if (!isset($_GET['id'])) {
    header('Location: painel.php');
    exit;
}

$id = $_GET['id'];

if (!isset($_SESSION['tarefas'][$id])) {
    echo "Tarefa não encontrada.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $novoStatus = $_POST['status'];
    $statusAntigo = $_SESSION['tarefas'][$id]['status'];

    $_SESSION['tarefas'][$id]['status'] = $novoStatus;

    $_SESSION['tarefas'][$id]['historico'][] = [
        'descricao' => 'Status alterado de ' . $statusAntigo . ' para ' . $novoStatus,
        'usuario' => $_SESSION['usuario_logado']['nome'],
        'data' => date('d/m/Y H:i')
    ];

    header('Location: detalhes_tarefa.php?id=' . $id);
    exit;
}

header('Location: detalhes_tarefa.php?id=' . $id);
exit;
?>