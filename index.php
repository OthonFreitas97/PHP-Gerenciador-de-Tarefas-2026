
<?php
session_start();


if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}


if (!isset($_SESSION['tarefas'])) {
    $_SESSION['tarefas'] = [];
}

$tarefas = $_SESSION['tarefas'];


$filtroStatus = '';

if (isset($_GET['status'])) {
    $filtroStatus = $_GET['status'];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Tarefas</title>
    <link rel="stylesheet" href="./assets/style.css">
</head>
<body>

<header>
    <h1>Gerenciador de Tarefas</h1>
</header>

<nav>
    <a href="index.php">Todas</a>
    <a href="?status=Pendente">Pendentes</a>
    <a href="?status=Em andamento">Em andamento</a>
    <a href="?status=Concluída">Concluídas</a>
    <a href="nova_tarefa.php">Nova Tarefa</a>
    <a href="logout.php">Sair</a>
</nav>

<main>

    <section>
        <h2>Lista de Tarefas</h2>

        <table border="1" width="100%">
            <tr>
                <th>Título</th>
                <th>Descrição</th>
                <th>Responsável</th>
                <th>Data Limite</th>
                <th>Status</th>
            </tr>

            <?php
            foreach ($tarefas as $tarefa) {

                if ($filtroStatus != '') {
                    if ($tarefa['status'] != $filtroStatus) {
                        continue;
                    }
                }
            ?>

            <tr>
                <td><?= $tarefa['titulo'] ?></td>
                <td><?= $tarefa['descricao'] ?></td>
                <td><?= $tarefa['responsavel'] ?></td>
                <td><?= $tarefa['data_limite'] ?></td>
                <td><?= $tarefa['status'] ?></td>
            </tr>

            <?php
            }
            ?>

        </table>
    </section>

</main>

<footer>
    <p>Trabalho PHP</p>
</footer>

</body>
</html>

<?php
session_start();


if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}


if (!isset($_SESSION['tarefas'])) {
    $_SESSION['tarefas'] = [];
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $responsavel = $_POST['responsavel'];
    $dataLimite = $_POST['data_limite'];
    $status = $_POST['status'];

    $novaTarefa = [
        'titulo' => $titulo,
        'descricao' => $descricao,
        'responsavel' => $responsavel,
        'data_limite' => $dataLimite,
        'status' => $status
    ];

    $_SESSION['tarefas'][] = $novaTarefa;

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Tarefa</title>
    <link rel="stylesheet" href="./assets/style.css">
</head>
<body>

<header>
    <h1>Nova Tarefa</h1>
</header>

<main>

    <form action="" method="post">

        <div class="form-group">
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" id="titulo" required>
        </div>

        <div class="form-group">
            <label for="descricao">Descrição:</label>
            <textarea name="descricao" id="descricao" required></textarea>
        </div>

        <div class="form-group">
            <label for="responsavel">Responsável:</label>
            <input type="text" name="responsavel" id="responsavel" required>
        </div>

        <div class="form-group">
            <label for="data_limite">Data Limite:</label>
            <input type="date" name="data_limite" id="data_limite" required>
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <select name="status" id="status">
                <option value="Pendente">Pendente</option>
                <option value="Em andamento">Em andamento</option>
                <option value="Concluída">Concluída</option>
            </select>
        </div>

        <button type="submit">Cadastrar Tarefa</button>

    </form>

</main>

<footer>
    <p>Trabalho PHP</p>
</footer>

</body>
</html>
