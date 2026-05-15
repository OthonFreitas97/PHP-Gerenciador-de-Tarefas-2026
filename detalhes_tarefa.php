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

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Tarefa</title>

    <link rel="stylesheet" href="./assets/style.css">
</head>
<body>
    <main>
        <h1>Detalhes da Tarefa</h1>

        <section class="card">

            <h2><?php echo htmlspecialchars($tarefa['titulo']); ?></h2>

            <p>
                <strong>Descrição:</strong>

                <?php echo htmlspecialchars($tarefa['descricao']); ?>
            </p>

            <p>
                <strong>Data limite:</strong>

                <?php echo htmlspecialchars($tarefa['data_limite']); ?>
            </p>

            <p>
                <strong>Status:</strong>

                <?php echo htmlspecialchars($tarefa['status']); ?>
            </p>


            <?php if (isset($tarefa['responsavel'])) { ?>

            <p>
                <strong>Responsável:</strong>

                <?php echo htmlspecialchars($tarefa['responsavel']); ?>
            </p>

            <?php } ?>


            <?php if (isset($tarefa['criador'])) { ?>

            <p>
                <strong>Criada por:</strong>

                <?php echo htmlspecialchars($tarefa['criador']); ?>
            </p>

            <?php } ?>

        </section>


        <section class="card">

            <h2>Adicionar Comentário</h2>

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


        <section class="card">

            <h2>Comentários</h2>


            <?php if (empty($comentarios)) { ?>

            <p>Nenhum comentário ainda.</p>

            <?php } else { ?>


            <?php foreach ($comentarios as $comentario) { ?>

                <article class="comentario">

                    <p>
                        <strong>
                            <?php echo htmlspecialchars($comentario['usuario']); ?>
                        </strong>
                    </p>

                    <p>
                        <?php echo htmlspecialchars($comentario['texto']); ?>
                    </p>

                    <small>
                        <?php echo htmlspecialchars($comentario['data']); ?>
                    </small>

                </article>

                <?php } ?>

            <?php } ?>

        </section>

     <section class="card">

        <h2>Histórico de Alterações</h2>


        <?php if (empty($historico)) { ?>

            <p>Nenhuma alteração registrada.</p>

        <?php } else { ?>


            <?php foreach ($historico as $item) { ?>

                <article class="historico">

                    <p>
                        <?php echo htmlspecialchars($item['descricao']); ?>
                    </p>

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

        <a href="painel.php">
        Voltar para o painel
        </a>
    </main>
</body>
</html>