<?php
require_once 'init.php';

verificarAcesso();

if (isset($_SESSION['tarefas'])) {
    $tarefas = $_SESSION['tarefas'];
} else {
    $tarefas = [];
}

$filtro_status = '';
$filtro_responsavel = '';
$filtro_data = '';

if (isset($_GET['status'])) {
    $filtro_status = $_GET['status'];
}

if (isset($_GET['responsavel'])) {
    $filtro_responsavel = $_GET['responsavel'];
}

if (isset($_GET['data'])) {
    $filtro_data = $_GET['data'];
}

$responsaveis = [];

foreach ($tarefas as $tarefa) {

    if (
        !empty($tarefa['responsavel']) &&
        !in_array($tarefa['responsavel'], $responsaveis)
    ) {

        $responsaveis[] = $tarefa['responsavel'];
    }
}

$tarefas_filtradas = [];

foreach ($tarefas as $id => $tarefa) {

    // Filtro de status
    if ($filtro_status != '') {

        if ($tarefa['status'] != $filtro_status) {
            continue;
        }
    }

    // Filtro de responsável
    if ($filtro_responsavel != '') {

        if ($tarefa['responsavel'] != $filtro_responsavel) {
            continue;
        }
    }

    // Filtro de data
    if ($filtro_data != '') {

        if ($tarefa['data_vencimento'] != $filtro_data) {
            continue;
        }
    }

    // Mantém o índice original
    $tarefas_filtradas[$id] = $tarefa;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <title>Painel de Tarefas</title>

    <link rel="stylesheet" href="./assets/style.css">

</head>

<body>

<header>

    <h1>Gerenciador de Tarefas</h1>

    <p>
        Usuário logado:
        <?php echo htmlspecialchars($_SESSION['usuario_logado']['nome']); ?>
    </p>

</header>

<nav>

    <a href="painel.php">Todas</a>

    <a href="painel.php?status=pendente">
        Pendentes
    </a>

    <a href="painel.php?status=andamento">
        Em andamento
    </a>

    <a href="painel.php?status=concluida">
        Concluídas
    </a>

    <a href="nova_tarefa.php">
        Nova Tarefa
    </a>

    <a href="logout.php">
        Sair
    </a>

</nav>

<main>

    <section class="card">

        <h2>Filtros</h2>

        <form method="GET">

            <div class="form-group">

                <label for="responsavel">
                    Responsável
                </label>

                <select name="responsavel" id="responsavel">

                    <option value="">
                        Todos
                    </option>

                    <?php foreach ($responsaveis as $responsavel) { ?>

                        <option
                            value="<?php echo $responsavel; ?>">

                            <?php echo $responsavel; ?>

                        </option>

                    <?php } ?>

                </select>

            </div>


            <div class="form-group">

                <label for="data">
                    Data
                </label>

                <input
                    type="date"
                    name="data"
                    id="data">

            </div>


            <button type="submit">
                Filtrar
            </button>

        </form>

    </section>


    <section class="card">

        <h2>Lista de Tarefas</h2>

        <?php if (empty($tarefas_filtradas)) { ?>

            <p>
                Nenhuma tarefa encontrada.
            </p>

        <?php } else { ?>

            <?php foreach ($tarefas_filtradas as $id => $tarefa) { ?>

                <div class="tarefa">

                    <div class="tarefa-info">

                        <h3>
                            <?php echo htmlspecialchars($tarefa['titulo']); ?>
                        </h3>

                        <p>
                            <?php echo htmlspecialchars($tarefa['descricao']); ?>
                        </p>

                        <p>
                            <strong>Responsável:</strong>

                            <?php echo htmlspecialchars($tarefa['responsavel']); ?>
                        </p>


                        <?php if (!empty($tarefa['data_vencimento'])) { ?>

                            <p class="tarefa-data">

                                <?php echo date(
                                    'd/m/Y',
                                    strtotime($tarefa['data_vencimento'])
                                ); ?>

                            </p>

                        <?php } ?>

                    </div>


                    <div class="tarefa-meta">

                        <span class="badge badge-<?php echo $tarefa['status']; ?>">

                            <?php
                            $labels = [

                                'pendente' => 'Pendente',
                                'andamento' => 'Em andamento',
                                'concluida' => 'Concluída'

                            ];

                            echo $labels[$tarefa['status']];
                            ?>

                        </span>


                        <a
                            href="detalhes_tarefa.php?id=<?php echo $id; ?>"
                            class="btn-detalhes">

                            Ver detalhes

                        </a>

                    </div>

                </div>

            <?php } ?>

        <?php } ?>

    </section>

</main>

</body>
</html>