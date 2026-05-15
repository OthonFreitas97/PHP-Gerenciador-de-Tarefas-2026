<?php
session_start();

if (!isset($_SESSION['usuarios'])) {
    $_SESSION['usuarios'] = [];
}

if (!isset($_SESSION['tarefas'])) {
    $_SESSION['tarefas'] = [];
}

date_default_timezone_set('America/Sao_Paulo');

function verificarAcesso() {
    if (!isset($_SESSION['usuario_logado'])) {
        header('Location: index.php');
        exit;
    }
}
?>