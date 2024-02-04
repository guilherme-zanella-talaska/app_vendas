<?php

namespace Repository;

use DB\MySQL;
use InvalidArgumentException;
use Util\ConstantesGenericasUtil;

class FormasPagamentoRepository{

    private $MySql;
    public const TABELA = "formas_pagamento";

    public function __construct(){
        $this->MySql = new MySQL();
    }

    public function getMysql(){
        return $this->MySql;
    }

    public function updatePay($id, $dados)
    {
        $query = 'UPDATE ' . self::TABELA . ' SET descricao = :descricao, qtd_parcelas = :qtd_parcelas, status = :status WHERE id = :id';
        $this->MySql->getDb()->beginTransaction();
        $stmt = $this->MySql->getDb()->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindValue(':descricao', $dados['descricao']);
        $stmt->bindValue(':qtd_parcelas', $dados['qtd_parcelas']);
        $stmt->bindValue(':status', $dados['status']);
        $stmt->execute();
      
        return $stmt->rowCount();
    }

    public function inserir($dados = [])
    { 
        $qtd_parcelas = (int)$dados['qtd_parcelas'];
        $status = (int)$dados['status'];
        
        $query = 'INSERT INTO ' . self::TABELA . ' (descricao, qtd_parcelas, status) VALUES (:descricao, :qtd_parcelas, :status)';
        $this->MySql->getDb()->beginTransaction();
        $stmt = $this->MySql->getDb()->prepare($query);
        $stmt->bindParam(':descricao', $dados['descricao']);
        $stmt->bindParam(':qtd_parcelas', $qtd_parcelas);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt->rowCount();
    }
}