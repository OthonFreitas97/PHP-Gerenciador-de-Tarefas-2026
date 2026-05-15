<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');

require_once __DIR__ . '/model/Usuario.php';
require_once __DIR__ . '/model/Tarefa.php';

if (!isset($_SESSION['usuarios'])) {
    $_SESSION['usuarios'] = [];
}

if (!isset($_SESSION['tarefas'])) {
    $_SESSION['tarefas'] = [];
}

function verificarAcesso() {
    if (!isset($_SESSION['usuario_logado'])) {
        header('Location: index.php');
        exit;
    }
}