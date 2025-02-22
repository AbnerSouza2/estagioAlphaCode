<?php
require_once '../config/database.php';
require_once '../controllers/ContatoController.php';

$contatoController = new ContatoController();

// Processar Exclusão
if (isset($_POST['excluir']) && isset($_POST['id'])) {
    $contatoController->excluir_cadastro($_POST['id']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['atualizar']) && isset($_POST['id'])) {
    $dadosContato = [
        'id' => $_POST['id'],
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

    $resultado = $contatoController->atualizar_cadastro($dadosContato);
    
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

   <!-- Toast Notification -->
<div aria-live="polite" aria-atomic="true" class="position-relative">
  <div class="toast-container top-0 end-0 p-3">
    <div id="toastSuccess" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true" <?= isset($_GET['sucesso']) ? 'style="display:block;"' : 'style="display:none;"' ?>>
      <div class="d-flex">
        <div class="toast-body">
          Cadastro realizado com sucesso!
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>
</div>

    <div class="container mt-0">
        <div class="topo_cadastro">
            <img src="../public/assets/logo_alphacode.png" alt="">
            <h3>Cadastro de Contatos</h3>
        </div>

        <!-- Formulário de Cadastro -->
        <form method="POST" class="formulario_cadastro" action="index.php">
            <div class="row">
                <div class="col-md-6 label-cadastro">
                    <div class="mb-5">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="EX.: Abner de Souza" required>
                    </div>
                    <div class="mb-5">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="EX.: abnersouza26@gmail.com" required>
                    </div>
                    <div class="mb-5">
                        <label for="telefone" class="form-label">Telefone para Contato</label>
                        <input type="text" class="form-control" id="telefone" name="telefone" placeholder="(19) 4033-2019">
                    </div>
                </div>

                <div class="col-md-6 label-cadastro">
                    <div class="mb-5">
                        <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                        <input type="text" class="form-control" id="data_nascimento" name="data_nascimento" 
                               placeholder=" Ex.: 18/12/1996" onfocus="(this.type='date')" 
                               onblur="if(!this.value) this.type='text'">
                    </div>
                    <div class="mb-5">
                        <label for="profissao" class="form-label">Profissão</label>
                        <input type="text" class="form-control" id="profissao" name="profissao" placeholder="EX.: Desenvolvedor Full-Stack" required>
                    </div>
                    <div class="mb-5">
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
            <h3 class="mt-5">Contatos Cadastrados</h3>
        </div>

        <div class="table-responsive tabela-cadastro-geral">
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
                            <td><?= (new DateTime($contato['data_nascimento']))->format('d/m/Y') ?></td>
                            <td><?= $contato['email'] ?></td>
                            <td><?= $contato['celular'] ?></td>
                            <td>

                            <button type="button" class="p-2 border-0 bg-transparent icones-cadastro" data-bs-toggle="modal" data-bs-target="#editModal<?= $contato['id'] ?>">
                                <img src="../public/assets/editar.png" alt="Editar" style="width: 20px; height: 20px;">
                            </button>

                                <form method="POST" action="index.php" class="d-inline" id="form-excluir-<?= $contato['id'] ?>">
                                    <input type="hidden" name="id" value="<?= $contato['id'] ?>">
                                    <button type="button" class="btn-excluir icones-cadastro" data-id="<?= $contato['id'] ?>" style="border: none; background: none;">
                                        <img src="../public/assets/excluir.png" alt="Excluir" style="width: 20px; height: 20px;">
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal de Edição para o contato -->
                    <div class="modal fade" id="editModal<?= $contato['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $contato['id'] ?>" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content shadow-lg rounded-5 border-0">
                                <div class="modal-header bg rounded-top-4 modal-cabecalho">
                                    <h5 class="modal-title" id="editModalLabel<?= $contato['id'] ?>">Editar Contato</h5>
                                </div>
                                <div class="modal-body p-4">
                                    <form action="index.php" method="POST">
                                        <input type="hidden" name="id" value="<?= $contato['id'] ?>">

                                        <div class="mb-3">
                                            <label for="nome" class="form-label fw-bold">Nome</label>
                                            <input type="text" class="form-control rounded-3" id="nome" name="nome" value="<?= $contato['nome'] ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="data_nascimento" class="form-label fw-bold">Data de nascimento</label>
                                            <input type="date" class="form-control rounded-3" id="data_nascimento" name="data_nascimento" value="<?= $contato['data_nascimento'] ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label for="email" class="form-label fw-bold">Email</label>
                                            <input type="email" class="form-control rounded-3" id="email" name="email" value="<?= $contato['email'] ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="telefone" class="form-label fw-bold">Telefone</label>
                                            <input type="text" class="form-control rounded-3" id="telefone" name="telefone" value="<?= $contato['telefone'] ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label for="celular" class="form-label fw-bold">Celular</label>
                                            <input type="text" class="form-control rounded-3" id="celular" name="celular" value="<?= $contato['celular'] ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="profissao" class="form-label fw-bold">Profissão</label>
                                            <input type="text" class="form-control rounded-3" id="profissao" name="profissao" value="<?= $contato['profissao'] ?>">
                                        </div>

                                        <div class="form-check my-2">
                                            <input class="form-check-input" type="checkbox" id="whatsapp" name="whatsapp" <?= $contato['whatsapp'] ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="whatsapp">Número de celular possui WhatsApp</label>
                                        </div>

                                        <div class="form-check my-2">
                                            <input class="form-check-input" type="checkbox" id="sms_notificacao" name="sms_notificacao" <?= $contato['sms_notificacao'] ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="sms_notificacao">Enviar notificações por SMS</label>
                                        </div>

                                        <div class="form-check my-2">
                                            <input class="form-check-input" type="checkbox" id="email_notificacao" name="email_notificacao" <?= $contato['email_notificacao'] ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="email_notificacao">Enviar notificações por e-mail</label>
                                        </div>

                                        <div class="modal-footer border-0 mt-4">
                                            <button type="button" class="btn btn-secondary rounded-3 modal-cancelar" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary rounded-3 px-4 modal-salvar" name="atualizar">Salvar alterações</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


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
