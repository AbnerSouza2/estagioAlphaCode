<?php
require_once '../config/database.php';

class Contato {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    // Listar todos os contatos
    public function listar() {
        $sql = "SELECT id, nome, email, telefone, data_nascimento, profissao, celular, whatsapp, sms_notificacao, email_notificacao FROM contatos ORDER BY id DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    // Adicionar novo contato
public function salvar($dados) {
    $stmt = $this->conn->prepare("INSERT INTO contatos (nome, email, telefone, celular, data_nascimento, profissao, whatsapp, email_notificacao, sms_notificacao) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $resultado = $stmt->execute([
        $dados['nome'], 
        $dados['email'], 
        $dados['telefone'], 
        $dados['celular'],
        $dados['data_nascimento'], 
        $dados['profissao'], 
        isset($dados['whatsapp']) ? 1 : 0,
        isset($dados['email_notificacao']) ? 1 : 0, 
        isset($dados['sms_notificacao']) ? 1 : 0
    ]);

    // Se o cadastro for bem-sucedido, define uma flag para exibir a Toast Notification
    if ($resultado) {
        header("Location: index.php?sucesso=1");
        exit();
    }
}


    public function atualizar($dados) {
        if (!isset($dados['id'])) {
            return false;  
        }
    
        $stmt = $this->conn->prepare("
            UPDATE contatos SET nome=?, email=?, telefone=?, celular=?, data_nascimento=?, profissao=?, whatsapp=?, email_notificacao=?, sms_notificacao=? WHERE id=?");
    
        return $stmt->execute([
            $dados['nome'], 
            $dados['email'], 
            $dados['telefone'],
            $dados['celular'],
            $dados['data_nascimento'], 
            $dados['profissao'], 
            $dados['whatsapp'],
            $dados['email_notificacao'], 
            $dados['sms_notificacao'],
            $dados['id']
        ]);
    }
    
    // Excluir um contato
    public function excluir($id) {
        $stmt = $this->conn->prepare("DELETE FROM contatos WHERE id=?");
        return $stmt->execute([$id]);
    }
}
?>