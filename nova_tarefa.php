<?php
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
