<?php
require_once 'init.php';
?>
<ul class="menu">
    <li><a href="painel.php">Painel</a></li>
    <li><a href="nova_tarefa.php">Nova Tarefa</a></li>
    <?php if (isset($_SESSION['usuario_logado'])): ?>
        <li><a href="logout.php">Sair (<?= htmlspecialchars($_SESSION['usuario_logado']['nome']) ?>)</a></li>
    <?php endif; ?>
</ul>
