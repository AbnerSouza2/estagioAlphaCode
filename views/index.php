<?php
require_once '../config/database.php';
require_once '../controllers/ContatoController.php';

$contatoController = new ContatoController();

// Processar Exclusão
if (isset($_POST['excluir']) && isset($_POST['id'])) {
    $contatoController->excluir_cadastro($_POST['id']);
    exit(); 
}

// Processar Cadastro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'])) {
    $dadosContato = [
        'nome' => $_POST['nome'],
        'email' => $_POST['email'],
        'telefone' => $_POST['telefone'],
        'data_nascimento' => $_POST['data_nascimento'],
        'profissao' => $_POST['profissao'],
        'celular' => $_POST['celular'],
        'whatsapp' => isset($_POST['whatsapp']) ? 1 : 0,
        'sms_notificacao' => isset($_POST['sms_notificacao']) ? 1 : 0,
        'email_notificacao' => isset($_POST['email_notificacao']) ? 1 : 0,
    ];

    $contatoController->salvar_cadastro($dadosContato);
    header('Location: index.php');
    exit();
}

$contatos = $contatoController->index();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alphacode Cadastros</title>
    <link rel="icon" type="image/png" href="../public/assets/logo_alphacode.png">
    <link rel="stylesheet" href="../public/css/cadastro.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-0">
        <div class="topo_cadastro">
            <img src="../public/assets/logo_alphacode.png" alt="">
            <h2>Cadastro de Contatos</h2>
        </div>

        <!-- Formulário de Cadastro -->
        <form method="POST" class="formulario_cadastro" action="index.php">
            <div class="row">
                <div class="col-md-6 label-cadastro">
                    <div class="mb-4">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="EX.: Abner de Souza" required>
                    </div>
                    <div class="mb-4">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="EX.: abnersouza26@gmail.com" required>
                    </div>
                    <div class="mb-4">
                        <label for="telefone" class="form-label">Telefone para Contato</label>
                        <input type="text" class="form-control" id="telefone" name="telefone" placeholder="(19) 4033-2019">
                    </div>
                </div>

                <div class="col-md-6 label-cadastro">
                    <div class="mb-4">
                        <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                        <input type="text" class="form-control" id="data_nascimento" name="data_nascimento" 
                               placeholder=" Ex.: 18/12/1996" onfocus="(this.type='date')" 
                               onblur="if(!this.value) this.type='text'">
                    </div>
                    <div class="mb-4">
                        <label for="profissao" class="form-label">Profissão</label>
                        <input type="text" class="form-control" id="profissao" name="profissao" placeholder="EX.: Desenvolvedor Full-Stack" required>
                    </div>
                    <div class="mb-4">
                        <label for="celular" class="form-label">Celular para Contato</label>
                        <input type="text" class="form-control" id="celular" name="celular" placeholder="EX.: (19) 98134-4568" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-check formulario_checkbox">
                        <input class="form-check-input" type="checkbox" id="whatsapp" name="whatsapp">
                        <label class="form-check-label" for="whatsapp">Número de celular possui WhatsApp</label>
                    </div>
                    <div class="form-check formulario_checkbox">
                        <input class="form-check-input" type="checkbox" id="sms_notificacao" name="sms_notificacao">
                        <label class="form-check-label" for="sms_notificacao">Enviar notificações por SMS</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-check formulario_checkbox">
                        <input class="form-check-input" type="checkbox" id="email_notificacao" name="email_notificacao">
                        <label class="form-check-label" for="email_notificacao">Enviar notificações por e-mail</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 d-flex justify-content-end">
                    <button type="submit" name="salvar" class="btn btn-info mt-4">Cadastrar Contato</button>
                </div>
            </div>
        </form>

        <hr>

        <!-- Tabela com contatos cadastrados -->
        <div class="contatos_cadastrados">
            <h2 class="mt-5">Contatos Cadastrados</h2>
        </div>

        <div class="table-responsive"> 
            <table class="table table-hover tabela_cadastros">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Data de Nascimento</th>
                        <th>Email</th>
                        <th>Celular para contato</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody class="tabela_informacoes_cadastradas">
                    <?php foreach ($contatos as $contato): ?>
                        <tr>
                            <td><?= $contato['nome'] ?></td>
                            <td><?= $contato['data_nascimento'] ?></td>
                            <td><?= $contato['email'] ?></td>
                            <td><?= $contato['celular'] ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $contato['id'] ?>">Editar</button>

                                <form method="POST" action="index.php" class="d-inline" id="form-excluir-<?= $contato['id'] ?>">
                                    <input type="hidden" name="id" value="<?= $contato['id'] ?>">
                                    <button type="button" class="btn-excluir" data-id="<?= $contato['id'] ?>" style="border: none; background: none;">
                                        <img src="../public/assets/excluir.png" alt="Excluir" style="width: 20px; height: 20px;">
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <footer class="mt-5 py-4 rodape">
            <div class="container">
                <div class="row mx-2">
                    <div class="col-12 col-md-4 text-center text-md-start">
                        <a href="#" class="text-white">Termos</a> | <a href="#" class="text-white">Políticas</a>
                    </div>

                    <div class="col-12 col-md-4 text-center">
                        <span>&copy; Copyright 2022 | Desenvolvido por</span>
                        <a href="https://site.alphacode.com.br/" target="_blank">
                            <img src="../public/assets/logo_rodape_alphacode.png" alt="Logo rodapé Alphacode" style="width: 105px;">
                        </a>
                    </div>

                    <div class="col-12 col-md-4 text-center text-md-end">
                        <span>&copy;Alphacode IT Solutions 2022</span>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="../public/js/cadastro.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
