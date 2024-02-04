<?php

namespace Repository;

use DB\MySQL;
use InvalidArgumentException;
use Util\ConstantesGenericasUtil;

class VendasRepository{

    private $MySql;
    public const TABELA = "vendas";
    public const TABELA_PRODUTOS = "vendas_produtos";
    public const PRODUTOS = "produtos";

    public function __construct(){
        $this->MySql = new MySQL();
    }

    public function getMysql(){
        return $this->MySql;
    }

    public function inserir($dados)
    { 

        $id_cliente = (int)$dados['cliente'];
        $forma_pagamento = (int)$dados['pagamento'];
        $qtd_parcelas = (int)$dados['qtd_parcelas'];
        $data_lancamento = date('Y-m-d H:i:s', strtotime($dados['data_lancamento']));

        $query = 
        'INSERT INTO ' . self::TABELA . ' 
            (id_cad_clientes, id_cad_forma_pagamento, qtd_parcelas, data_lancamento)
        VALUES
            (:id_cad_clientes, :id_cad_forma_pagamento, :qtd_parcelas, :data_lancamento)
        ';

        $this->MySql->getDb()->beginTransaction();
        $stmt = $this->MySql->getDb()->prepare($query);
        $stmt->bindParam(':id_cad_clientes', $id_cliente);
        $stmt->bindParam(':id_cad_forma_pagamento', $forma_pagamento);
        $stmt->bindParam(':qtd_parcelas', $qtd_parcelas); 
        $stmt->bindParam(':data_lancamento', $data_lancamento); 
        $stmt->execute();
  
        return $stmt->rowCount();
    }

    public function inserirProdutos($dados)
    { 

       $produtos = $this->getMysql()->getAll(self::PRODUTOS);
       $this->getMysql()->getDb()->beginTransaction();
    
       foreach ($dados as $item) {
            $id_produto_dados = $item["id_produto"];
            $quantidade_dados = $item["quantidade"];

            foreach ($produtos as $produto) {

                $id_produto_produtos = $produto["id"];

                if ($id_produto_dados == $id_produto_produtos) {
                    $nova_quantidade = $produto["quantidade"] - $quantidade_dados;
                    $query = "UPDATE ".self::PRODUTOS." SET quantidade = :nova_quantidade WHERE id = :id_produto";
                    $stmt = $this->getMysql()->getDb()->prepare($query);
                    $stmt->bindParam(':nova_quantidade', number_format($nova_quantidade, 2, '.', ','));
                    $stmt->bindParam(':id_produto', $id_produto_dados);
                    $stmt->execute();
                }
            }
        }

        $queryInsert = 
        'INSERT INTO ' . self::TABELA_PRODUTOS . ' 
            (id_cad_vendas, id_cad_produto, qtd_vendida)
        VALUES
            (:id_cad_vendas, :id_cad_produto, :qtd_vendida)
        ';

        $stmt = $this->MySql->getDb()->prepare($queryInsert);
  
        foreach ($dados as $item) {
            $id_cad_vendas  = $item['id_venda']; 
            $id_cad_produto = $item['id_produto'];
            $qtd_vendida    = $item['quantidade'];

            $stmt->bindParam(':id_cad_vendas',  $id_cad_vendas);
            $stmt->bindParam(':id_cad_produto', $id_cad_produto);
            $stmt->bindParam(':qtd_vendida',    number_format($qtd_vendida, 2, '.', ',')); 
            $stmt->execute();

        }
        return $stmt->rowCount();
    }
}