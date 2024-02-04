<?php

namespace Service;

use Repository\VendasRepository;
use InvalidArgumentException;
use Util\ConstantesGenericasUtil;

Class VendasService
{
    public const TABELA = 'vendas';
    public const TABELA_PRODUTOS = 'vendas_produtos';
    public const RECURSOS_POST = ['cadastrar', 'cadastrar_produtos'];

    private $dados;
    private $dadosCorpoRequest;
    private $VendasRepository;

    public function __construct($dados = [])
    {
        $this->dados = $dados;
        $this->VendasRepository = new VendasRepository();
    }

    public function setDadosRequest($dados)
    {
        $this->dadosCorpoRequest = $dados;
    }

    public function validarGet()
    {
        $retorno = null;
        $recurso = $this->dados['recurso'];
        if (in_array($recurso, self::RECURSOS_GET, true)) {
            $retorno = $this->dados['id'] > 0 ? $this->getOneByKey() : $this->$recurso();
        } else {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
        }
 
        if($retorno == null){
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }

        return $retorno;
    }

    public function validarPost()
    {

        $retorno = null;
        $recurso = $this->dados['recurso'];
    
        if (in_array($recurso, self::RECURSOS_POST, true)) {
            $retorno = $this->$recurso();
        } else {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
        }
 
        if($retorno == null){
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }

        return $retorno;
    }

    private function getOneByKey()
    {
        return $this->ClientesRepository->getMysql()->getOneByKey(self::TABELA, $this->dados['id']);
    }

    private function listar()
    {
        return $this->ClientesRepository->getMysql()->getAll(self::TABELA);
    }

    private function cadastrar()
    {
    
        if($this->dadosCorpoRequest){
            
            if ($this->VendasRepository->inserir($this->dadosCorpoRequest) > 0) {
                
                $idInserido = $this->VendasRepository->getMySQL()->getDb()->lastInsertId();
                $this->VendasRepository->getMySQL()->getDb()->commit();
                return array(
                    'status' => ConstantesGenericasUtil::MSG_INSERIDO_SUCESSO,
                    'id_inserido' => $idInserido
                );
            }
            $this->VendasRepository->getMySql()->getDb()->rollBack();
        }

        throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
    }

    private function cadastrar_produtos()
    {
    
        if($this->dadosCorpoRequest){
            
            if ($this->VendasRepository->inserirProdutos($this->dadosCorpoRequest) > 0) {
                $this->VendasRepository->getMySQL()->getDb()->commit();
                return ConstantesGenericasUtil::MSG_INSERIDO_SUCESSO;
            }
            $this->VendasRepository->getMySql()->getDb()->rollBack();
        }

        throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
    }

}