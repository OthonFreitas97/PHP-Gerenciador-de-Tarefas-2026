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

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Tarefa</title>

     <!-- Importa o arquivo CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <h1>Detalhes da Tarefa</h1>

        <!-- Card com informações da tarefa -->
        <section class="card">

            <!-- Exibe o título da tarefa -->
            <h2><?php echo htmlspecialchars($tarefa['titulo']); ?></h2>

            <p>
                <strong>Descrição:</strong>

                <!-- Exibe a descrição -->
                <?php echo htmlspecialchars($tarefa['descricao']); ?>
            </p>

            <p>
                <strong>Data limite:</strong>

                <!-- Exibe a data limite -->
                <?php echo htmlspecialchars($tarefa['data_limite']); ?>
            </p>

            <p>
                <strong>Status:</strong>

                <!-- Exibe o status -->
                <?php echo htmlspecialchars($tarefa['status']); ?>
            </p>


            <!-- Verifica se existe responsável -->
            <?php if (isset($tarefa['responsavel'])) { ?>

            <p>
                <strong>Responsável:</strong>

                <!-- Exibe o responsável -->
                <?php echo htmlspecialchars($tarefa['responsavel']); ?>
            </p>

            <?php } ?>


            <!-- Verifica se existe criador -->
            <?php if (isset($tarefa['criador'])) { ?>

            <p>
                <strong>Criada por:</strong>

                <!-- Exibe o criador -->
                <?php echo htmlspecialchars($tarefa['criador']); ?>
            </p>

            <?php } ?>

        </section>


        <!-- Área para adicionar comentário -->
        <section class="card">

            <h2>Adicionar Comentário</h2>

            <!-- Formulário de comentário -->
            <form method="POST">

                <textarea
                    name="comentario"
                    placeholder="Digite seu comentário..."
                    required>
                </textarea>

                <button type="submit">
                Enviar comentário
                </button>

            </form>

        </section>


        <!-- Área que mostra os comentários -->
        <section class="card">

            <h2>Comentários</h2>


            <!-- Verifica se não existem comentários -->
            <?php if (empty($comentarios)) { ?>

            <p>Nenhum comentário ainda.</p>

            <?php } else { ?>


            <!-- Percorre todos os comentários -->
            <?php foreach ($comentarios as $comentario) { ?>

                <article class="comentario">

                    <!-- Nome do usuário -->
                    <p>
                        <strong>
                            <?php echo htmlspecialchars($comentario['usuario']); ?>
                        </strong>
                    </p>

                    <!-- Texto do comentário -->
                    <p>
                        <?php echo htmlspecialchars($comentario['texto']); ?>
                    </p>

                    <!-- Data do comentário -->
                    <small>
                        <?php echo htmlspecialchars($comentario['data']); ?>
                    </small>

                </article>

                <?php } ?>

            <?php } ?>

        </section>


    <!-- Área de histórico -->
     <section class="card">

        <h2>Histórico de Alterações</h2>


        <!-- Verifica se existe histórico -->
        <?php if (empty($historico)) { ?>

            <p>Nenhuma alteração registrada.</p>

        <?php } else { ?>


            <!-- Percorre todos os itens do histórico -->
            <?php foreach ($historico as $item) { ?>

                <article class="historico">

                    <!-- Descrição da alteração -->
                    <p>
                        <?php echo htmlspecialchars($item['descricao']); ?>
                    </p>

                    <!-- Usuário e data -->
                    <small>
                        <?php echo htmlspecialchars($item['usuario']); ?>
                        -
                        <?php echo htmlspecialchars($item['data']); ?>
                    </small>

                </article>

            <?php } ?>

        <?php } ?>

        </section>

        <br>

        <!-- Link para voltar ao painel -->
        <a href="painel.php">
        Voltar para o painel
        </a>
    </main>
</body>
</html>