<?php

namespace Service;

use Repository\FormasPagamentoRepository;
use InvalidArgumentException;
use Util\ConstantesGenericasUtil;

Class FormasPagamentoService
{
    public const TABELA = 'formas_pagamento';
    public const RECURSOS_GET = ['listar'];
    public const RECURSOS_DELETE = ['deletar'];
    public const RECURSOS_PUT = ['atualizar'];
    public const RECURSOS_POST = ['cadastrar',];

    private $dados;
    private $dadosCorpoRequest;
    private $FormasPagamentoRepository;

    public function __construct($dados = [])
    {
        $this->dados = $dados;
        $this->FormasPagamentoRepository = new FormasPagamentoRepository();
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

    public function validarPut()
    {
        $retorno = null;
        $recurso = $this->dados['recurso'];

        if (in_array($recurso, self::RECURSOS_PUT, true)) {
            if($this->dados['id'] > 0){
                $retorno = $this->$recurso();
            }else{
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_ID_OBRIGATORIO);
            }
        } else {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
        }
 
        if($retorno == null){
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }

        return $retorno;
    }

    public function validarDelete()
    {
        $retorno = null;
        $recurso = $this->dados['recurso'];

        if (in_array($recurso, self::RECURSOS_DELETE, true)) {
            if($this->dados['id'] > 0){
                $retorno = $this->$recurso();
            }else{
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_ID_OBRIGATORIO);
            }
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

    private function atualizar()
    {
        if($this->FormasPagamentoRepository->updatePay($this->dados['id'], $this->dadosCorpoRequest) > 0){
            $this->FormasPagamentoRepository->getMySQL()->getDb()->commit();
            return ConstantesGenericasUtil::MSG_ATUALIZADO_SUCESSO;
        }

        $this->FormasPagamentoRepository->getMySql()->getDb()->rollBack();
        return ConstantesGenericasUtil::MSG_ATUALIZADO_SUCESSO;
    }

    private function getOneByKey()
    {
        return $this->FormasPagamentoRepository->getMysql()->getOneByKey(self::TABELA, $this->dados['id']);
    }

    private function listar()
    {
        return $this->FormasPagamentoRepository->getMysql()->getAll(self::TABELA);
    }

    private function deletar()
    {
        return $this->FormasPagamentoRepository->getMysql()->delete(self::TABELA, $this->dados['id']);
    }

    private function cadastrar()
    {
        if($this->dadosCorpoRequest){
            if ($this->FormasPagamentoRepository->inserir($this->dadosCorpoRequest) > 0) {
                $idInserido = $this->FormasPagamentoRepository->getMySQL()->getDb()->lastInsertId();
                $this->FormasPagamentoRepository->getMySQL()->getDb()->commit();
                return ConstantesGenericasUtil::MSG_INSERIDO_SUCESSO;
            }
            $this->FormasPagamentoRepository->getMySql()->getDb()->rollBack();
        }

        throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
    }


}