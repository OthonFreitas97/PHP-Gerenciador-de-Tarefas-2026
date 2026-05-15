<div class="container">
    <div class="card">
        <div class="card-header">
            <h1>Bem-vindo ao Gerenciador de Tarefas</h1>
            <p>Organize suas atividades de forma simples e eficiente</p>
        </div>
        <?php if (isset($_SESSION['usuario_logado'])): ?>
            <p>Olá, <?= htmlspecialchars($_SESSION['usuario_logado']['nome']) ?>!</p>
            <a href="painel.php" class="btn-primary">Ver Painel</a>
        <?php else: ?>
            <p>Faça login para começar a usar o sistema.</p>
            <a href="index.php" class="btn-primary">Ir para Login</a>
        <?php endif; ?>
    </div>
</div>
