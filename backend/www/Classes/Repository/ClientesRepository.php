<?php

namespace Repository;

use DB\MySQL;
use InvalidArgumentException;
use Util\ConstantesGenericasUtil;

class ClientesRepository{

    private $MySql;
    public const TABELA = "clientes";

    public function __construct(){
        $this->MySql = new MySQL();
    }

    public function getMysql(){
        return $this->MySql;
    }

    public function atualizar($id, $dados)
    {
        $status = (int)$dados['status'];
    
        $query = 'UPDATE ' . self::TABELA . ' SET nome = :nome, cpf = :cpf, endereco = :endereco, cep = :cep, email = :email, status = :status WHERE id = :id';
        $this->MySql->getDb()->beginTransaction();
        $stmt = $this->MySql->getDb()->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome',  $dados['nome']);
        $stmt->bindParam(':cpf', $dados['cpf']);
        $stmt->bindParam(':endereco', $dados['endereco']);
        $stmt->bindParam(':cep', $dados['cep']);
        $stmt->bindParam(':email', $dados['email']);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function inserir($dados = [])
    { 

        $status = (int)$dados['status'];
        $cep = $dados['cep'];

        $query = 'INSERT INTO ' . self::TABELA . ' 
        (nome,  cpf, endereco, cep, email, status) VALUES (:nome,  :cpf, :endereco, :cep, :email, :status)';
        $this->MySql->getDb()->beginTransaction();
        $stmt = $this->MySql->getDb()->prepare($query);
        $stmt->bindParam(':nome', $dados['nome']);
        $stmt->bindParam(':cpf', $dados['cpf']);
        $stmt->bindParam(':endereco', $dados['endereco']); 
        $stmt->bindParam(':cep', $cep); 
        $stmt->bindParam(':email', $dados['email']);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
  
        return $stmt->rowCount();
    }

    public function listar_vendas($id){

        $id_cliente = (int)$id;
        $query = 
        "SELECT
            a.qtd_parcelas,
            a.data_lancamento,
            b.nome as cliente,
            c.descricao as forma_pagamento,
            COALESCE(d.valor, 0) as valor
        FROM
            db_vendas.vendas as a
        LEFT JOIN
            db_vendas.clientes as b ON a.id_cad_clientes = b.id
        LEFT JOIN
            db_vendas.formas_pagamento as c ON a.id_cad_forma_pagamento = c.id
        LEFT JOIN
            (
                SELECT
                    SUM(aa.qtd_vendida * bb.valor) as valor,
                    aa.id_cad_vendas
                FROM
                    db_vendas.vendas_produtos as aa
                LEFT JOIN
                    db_vendas.produtos as bb ON aa.id_cad_produto = bb.id
                GROUP BY
                    aa.id_cad_vendas
            ) as d ON d.id_cad_vendas = a.id
        WHERE
            a.id_cad_clientes = :id";

        $stmt = $this->MySql->getDb()->prepare($query);
        $stmt->bindParam(':id', $id_cliente);
        $stmt->execute();

        $result = $stmt->fetchAll($this->MySql->getDb()::FETCH_ASSOC);
        return $result;

    }
}