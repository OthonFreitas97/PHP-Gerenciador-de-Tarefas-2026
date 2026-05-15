<?php

require_once 'init.php';

verificarAcesso();


// Verifica se o ID da tarefa foi enviado pela URL
if (!isset($_GET['id'])) {

    // Se não existir ID, volta para o painel
    header('Location: painel.php');
    exit;
}


// Guarda o ID da tarefa enviado pela URL
$id = $_GET['id'];


// Verifica se a tarefa existe dentro da sessão
if (!isset($_SESSION['tarefas'][$id])) {

    echo "Tarefa não encontrada.";
    exit;
}


// Guarda os dados da tarefa em uma variável
$tarefa = $_SESSION['tarefas'][$id];


// Verifica se o formulário foi enviado
// E se o campo comentario existe
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comentario'])) {

    // Remove espaços vazios do começo e fim do comentário
    $comentario = trim($_POST['comentario']);

    // Verifica se o comentário não está vazio
    if ($comentario != '') {

        // Adiciona o comentário dentro da tarefa
        $_SESSION['tarefas'][$id]['comentarios'][] = [

            // Nome do usuário logado
            'usuario' => $_SESSION['usuario_logado']['nome'],

            // Texto do comentário
            'texto' => $comentario,

            // Data e hora do comentário
            'data' => date('d/m/Y H:i')
        ];
    }

    // Recarrega a página após comentar
    header("Location: detalhes_tarefa.php?id=$id");
    exit;
}


// Verifica se existem comentários cadastrados
if (isset($_SESSION['tarefas'][$id]['comentarios'])) {

    // Guarda os comentários na variável
    $comentarios = $_SESSION['tarefas'][$id]['comentarios'];

} else {

    // Se não existir comentário, cria array vazio
    $comentarios = [];
}


// Verifica se existe histórico da tarefa
if (isset($_SESSION['tarefas'][$id]['historico'])) {

    // Guarda o histórico na variável
    $historico = $_SESSION['tarefas'][$id]['historico'];

} else {

    // Se não existir histórico, cria array vazio
    $historico = [];
}

?>