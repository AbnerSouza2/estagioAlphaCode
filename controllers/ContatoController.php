<?php
require_once '../config/database.php';

class ContatoController {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    // Método para listar todos os contatos.
    public function index() {
        $stmt = $this->conn->prepare("SELECT id, nome, data_nascimento, email, celular FROM contatos ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para adicionar um novo contato
    public function store($dados) {
        $stmt = $this->conn->prepare("INSERT INTO contatos (nome, email, telefone, celular, data_nascimento, profissao, whatsapp, email_notificacao, sms_notificacao) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $dados['nome'], $dados['email'], $dados['telefone'], $dados['celular'],
            $dados['data_nascimento'], $dados['profissao'], isset($dados['whatsapp']) ? 1 : 0,
            isset($dados['email_notificacao']) ? 1 : 0, isset($dados['sms_notificacao']) ? 1 : 0
        ]);
    }

    // Método para atualizar um cadastro existente
    public function update($dados) {
        $stmt = $this->conn->prepare("UPDATE contatos SET nome=?, email=?, telefone=?, celular=?, data_nascimento=?, profissao=?, whatsapp=?, email_notificacao=?, sms_notificacao=? WHERE id=?");
        $stmt->execute([
            $dados['nome'], $dados['email'], $dados['telefone'], $dados['celular'],
            $dados['data_nascimento'], $dados['profissao'], isset($dados['whatsapp']) ? 1 : 0,
            isset($dados['email_notificacao']) ? 1 : 0, isset($dados['sms_notificacao']) ? 1 : 0,
            $dados['id']
        ]);
    }

    // Método para excluir algum cadastro
    public function destroy($id) {
        $stmt = $this->conn->prepare("DELETE FROM contatos WHERE id=?");
        $stmt->execute([$id]);
    }
}
?>
