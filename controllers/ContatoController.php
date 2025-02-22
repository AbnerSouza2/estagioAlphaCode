<?php
require_once '../models/Contato.php';

class ContatoController {
    private $contatoModel;

    public function __construct() {
        $this->contatoModel = new Contato(); 
    }

    // Listar todos os contatos
    public function index() {
        return $this->contatoModel->listar(); 
    }

    // Adicionar um novo contato
    public function salvar_cadastro($dados) {
        $this->contatoModel->salvar($dados); 
    }

    // Atualizar um contato existente
    public function atualizar_cadastro($dados) {
        return $this->contatoModel->atualizar($dados); 
    }

    // Excluir um contato
    public function excluir_cadastro($id) {
        return $this->contatoModel->excluir($id); 
    }
}
?>