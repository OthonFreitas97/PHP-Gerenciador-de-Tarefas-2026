<?php


class Usuario {
    public $id;
    public $nome;
    public $email;
    public $senha;

    public function __construct($id = 0, $nome = "", $email = "", $senha = "") {
        $this->id = $id;
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
    }

    public function validar() {
        $erros = [];

        if (empty($this->nome)) {
            $erros[] = "O nome é obrigatório.";
        }

        if (empty($this->email) || !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $erros[] = "Informe um e-mail válido.";
        }

        if (strlen($this->senha) < 6) {
            $erros[] = "A senha deve ter no mínimo 6 caracteres.";
        }

        return $erros;
    }

    public function toString() {
        return "ID: {$this->id} | Nome: {$this->nome} | Email: {$this->email}";
    }
}

