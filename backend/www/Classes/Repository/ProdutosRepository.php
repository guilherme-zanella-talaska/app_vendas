<?php

namespace Repository;

use DB\MySQL;
use InvalidArgumentException;
use Util\ConstantesGenericasUtil;

class ProdutosRepository{

    private $MySql;
    public const TABELA = "produtos";

    public function __construct(){
        $this->MySql = new MySQL();
    }

    public function getMysql(){
        return $this->MySql;
    }

    public function inserir($dados = [])
    { 

        $quantidade = number_format($dados['quantidade'], 2, '.', ',');
        $valor = number_format($dados['valor'], 2, '.', ',');
        $status = (int)$dados['status'];
        
        $query = 'INSERT INTO ' . self::TABELA . ' (descricao, quantidade, valor, status) VALUES (:descricao, :quantidade, :valor, :status)';
        $this->MySql->getDb()->beginTransaction();
        $stmt = $this->MySql->getDb()->prepare($query);
        $stmt->bindParam(':descricao', $dados['descricao']);
        $stmt->bindParam(':quantidade', $quantidade);
        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function updateProduto($id, $dados)
    {
        $query = 'UPDATE ' . self::TABELA . ' SET descricao = :descricao, quantidade = :quantidade, valor = :valor, status = :status WHERE id = :id';
        $this->MySql->getDb()->beginTransaction();
        $stmt = $this->MySql->getDb()->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindValue(':descricao',  $dados['descricao']);
        $stmt->bindValue(':quantidade', $dados['quantidade']);
        $stmt->bindValue(':valor', number_format($dados['valor'], 2, '.', ','));
        $stmt->bindValue(':status', (int)$dados['status']);
        $stmt->execute();
        return $stmt->rowCount();
    }

}