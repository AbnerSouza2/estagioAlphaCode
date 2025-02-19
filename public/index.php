<?php

require_once '../config/database.php';
require_once '../controllers/ContatoController.php';

$contatoController = new ContatoController();
$contatos = $contatoController->index();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['salvar'])) {
        $contatoController->store($_POST);
        header("Location: index.php");
        exit();
    } elseif (isset($_POST['editar'])) {
        $contatoController->update($_POST);
        header("Location: index.php");
        exit();
    } elseif (isset($_POST['excluir'])) {
        $contatoController->destroy($_POST['id']);
        header("Location: index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Contatos</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Cadastro de Contatos</h2>
    <form method="POST" action="index.php">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome Completo</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="telefone" class="form-label">Telefone para Contato</label>
            <input type="text" class="form-control" id="telefone" name="telefone" required>
        </div>
        <div class="mb-3">
            <label for="celular" class="form-label">Celular para Contato</label>
            <input type="text" class="form-control" id="celular" name="celular" required>
        </div>
        <div class="mb-3">
            <label for="data_nascimento" class="form-label">Data de Nascimento</label>
            <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required>
        </div>
        <div class="mb-3">
            <label for="profissao" class="form-label">Profissão</label>
            <input type="text" class="form-control" id="profissao" name="profissao" required>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="whatsapp" name="whatsapp">
            <label class="form-check-label" for="whatsapp">Número de celular possui WhatsApp</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="email_notificacao" name="email_notificacao">
            <label class="form-check-label" for="email_notificacao">Enviar notificações por e-mail</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="sms_notificacao" name="sms_notificacao">
            <label class="form-check-label" for="sms_notificacao">Enviar notificações por SMS</label>
        </div>
        <button type="submit" name="salvar" class="btn btn-primary mt-3">Cadastrar Contato</button>
    </form>
    
    <h2 class="mt-5">Lista de Contatos</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Data de Nascimento</th>
                <th>Email</th>
                <th>Celular</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contatos as $contato): ?>
                <tr>
                    <td><?= $contato['nome'] ?></td>
                    <td><?= $contato['data_nascimento'] ?></td>
                    <td><?= $contato['email'] ?></td>
                    <td><?= $contato['celular'] ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $contato['id'] ?>">Editar</button>
                        <form method="POST" action="index.php" class="d-inline">
                            <input type="hidden" name="id" value="<?= $contato['id'] ?>">
                            <button type="submit" name="excluir" class="btn btn-danger btn-sm">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
