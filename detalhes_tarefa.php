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


$tarefa = $_SESSION['tarefas'][$id];


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comentario'])) {

    $comentario = trim($_POST['comentario']);

    if ($comentario != '') {

        $_SESSION['tarefas'][$id]['comentarios'][] = [

            'usuario' => $_SESSION['usuario_logado']['nome'],

            'texto' => $comentario,

            'data' => date('d/m/Y H:i')
        ];
    }

    header("Location: detalhes_tarefa.php?id=$id");
    exit;
}


if (isset($_SESSION['tarefas'][$id]['comentarios'])) {

    $comentarios = $_SESSION['tarefas'][$id]['comentarios'];

} else {

    $comentarios = [];
}


if (isset($_SESSION['tarefas'][$id]['historico'])) {

    $historico = $_SESSION['tarefas'][$id]['historico'];

} else {

    $historico = [];
}

?>