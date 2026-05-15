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

        $_SESSION['tarefas'][$id]['historico'][] = [
            'descricao' => 'Comentário adicionado',
            'usuario' => $_SESSION['usuario_logado']['nome'],
            'data' => date('d/m/Y H:i')
        ];
    }

    header('Location: detalhes_tarefa.php?id=' . $id);
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

$labels = [
    'pendente' => 'Pendente',
    'andamento' => 'Em andamento',
    'concluida' => 'Concluída'
];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Detalhes da Tarefa</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

<header>
    <nav>
        <?php require_once 'menu.php'; ?>
    </nav>
</header>

<main>

<div class="container">

    <div class="card">

        <div class="card-header">

            <h1>Detalhes da Tarefa</h1>

            <p>
                Visualize as informações completas da tarefa
            </p>

        </div>

        <h2>
            <?php echo htmlspecialchars($tarefa['titulo']); ?>
        </h2>

        <p>
            <strong>Descrição:</strong>

            <?php echo htmlspecialchars($tarefa['descricao']); ?>
        </p>

        <p>
            <strong>Responsável:</strong>

            <?php echo htmlspecialchars($tarefa['responsavel']); ?>
        </p>

        <p>
            <strong>Data de vencimento:</strong>

            <?php echo date(
                'd/m/Y H:i',
                strtotime($tarefa['data_vencimento'])
            ); ?>
        </p>

       <p>
            <strong>Status:</strong>
            <?php echo $labels[$tarefa['status']]; ?>
        </p>

        <?php 
        $usuarioLogado = $_SESSION['usuario_logado']['nome'];
        $pode_editar = ($tarefa['responsavel'] === $usuarioLogado || $tarefa['criador'] === $usuarioLogado);
        
        if ($pode_editar): 
        ?>
        <form action="atualizar_status.php?id=<?php echo $id; ?>" method="post">
            <div class="form-group">
                <label for="status">Atualizar status</label>
                <select name="status" id="status">
                    <option value="pendente" <?php if($tarefa['status'] == 'pendente') echo 'selected'; ?>>Pendente</option>
                    <option value="andamento" <?php if($tarefa['status'] == 'andamento') echo 'selected'; ?>>Em andamento</option>
                    <option value="concluida" <?php if($tarefa['status'] == 'concluida') echo 'selected'; ?>>Concluída</option>
                </select>
            </div>
            <button type="submit" class="btn-primary">Atualizar status</button>
        </form>
        <?php else: ?>
        <div class="alert" style="background: var(--bg); border: 1px solid var(--border); padding: 10px; border-radius: 8px; margin-bottom: 15px;">
            <p style="font-size: 0.9em; color: var(--text-muted); margin: 0;">
                <em>Apenas o criador (<?= htmlspecialchars($tarefa['criador'] ?? '') ?>) ou o responsável (<?= htmlspecialchars($tarefa['responsavel'] ?? '') ?>) podem alterar o status desta tarefa.</em>
            </p>
        </div>
        <?php endif; ?>


        <?php if (isset($tarefa['criador'])) { ?>

            <p>
                <strong>Criada por:</strong>

                <?php echo htmlspecialchars($tarefa['criador']); ?>
            </p>

        <?php } ?>

        <br>

        <a href="painel.php" class="btn-secondary">
            Voltar
        </a>

    </div>



    <div class="card">

        <h2>Adicionar comentário</h2>

        <form method="POST">

            <div class="form-group">

                <label for="comentario">
                    Comentário
                </label>

                <textarea
                    name="comentario"
                    id="comentario"
                    rows="4"
                    placeholder="Digite seu comentário"
                    required></textarea>

            </div>

            <button type="submit" class="btn-primary">
                Enviar comentário
            </button>

        </form>

    </div>



    <div class="card">

        <h2>Comentários</h2>

        <?php if (empty($comentarios)) { ?>

            <p>
                Nenhum comentário ainda.
            </p>

        <?php } else { ?>

            <?php foreach ($comentarios as $comentario) { ?>

                <div class="comentario">

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

                </div>

            <?php } ?>

        <?php } ?>

    </div>


    <div class="card">

        <h2>Histórico de Alterações</h2>

        <?php if (empty($historico)) { ?>

            <p>
                Nenhuma alteração registrada.
            </p>

        <?php } else { ?>

            <?php foreach ($historico as $item) { ?>

                <div class="historico">

                    <p>

                        <?php echo htmlspecialchars($item['descricao']); ?>

                    </p>

                    <small>

                        <?php echo htmlspecialchars($item['usuario']); ?>

                        -

                        <?php echo htmlspecialchars($item['data']); ?>

                    </small>

                </div>

            <?php } ?>

        <?php } ?>

    </div>

</div>

</main>

<footer>

    <small>
        Copyright &copy; - <?php echo date("Y"); ?> - Gerenciador de Tarefas
    </small>

</footer>

</body>
</html>
