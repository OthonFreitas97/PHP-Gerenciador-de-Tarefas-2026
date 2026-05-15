<?php


class Tarefa {
    public $id;
    public $titulo;
    public $descricao;
    public $status;
    public $responsavel;
    public $data_criacao;
    public $data_vencimento;
    public $usuario_id;

    public function __construct($id = 0, $titulo = "", $descricao = "", $status = "pendente", 
                                $responsavel = "", $data_vencimento = "", $usuario_id = 0) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->descricao = $descricao;
        $this->status = $status;
        $this->responsavel = $responsavel;
        $this->data_criacao = date('Y-m-d H:i:s');
        $this->data_vencimento = $data_vencimento;
        $this->usuario_id = $usuario_id;
    }

    public function validar() {
        $erros = [];

        if (empty($this->titulo)) {
            $erros[] = "O título é obrigatório.";
        }

        if (empty($this->descricao)) {
            $erros[] = "A descrição é obrigatória.";
        }

        if (empty($this->responsavel)) {
            $erros[] = "O responsável é obrigatório.";
        }

        if (empty($this->data_vencimento)) {
            $erros[] = "A data de vencimento é obrigatória.";
        }

        $status_validos = ['pendente', 'andamento', 'concluida'];
        if (!in_array($this->status, $status_validos)) {
            $erros[] = "Status inválido.";
        }

        return $erros;
    }

    public function toString() {
        return "Título: {$this->titulo} | Status: {$this->status} | Responsável: {$this->responsavel}";
    }
}

