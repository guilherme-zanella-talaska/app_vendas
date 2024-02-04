<?php

namespace Service;

use Repository\ProdutosRepository;
use InvalidArgumentException;
use Util\ConstantesGenericasUtil;

Class ProdutosService
{

    public const TABELA = 'produtos';
    public const RECURSOS_GET = ['listar'];
    public const RECURSOS_DELETE = ['deletar'];
    public const RECURSOS_PUT = ['atualizar'];
    public const RECURSOS_POST = ['cadastrar',];

    private $dados;
    private $dadosCorpoRequest;
    private $ProdutosRepository;

    public function __construct($dados = [])
    {
        $this->dados = $dados;
        $this->ProdutosRepository = new ProdutosRepository();
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

    private function getOneByKey()
    {
        return $this->ProdutosRepository->getMysql()->getOneByKey(self::TABELA, $this->dados['id']);
    }

    private function listar()
    {
        return $this->ProdutosRepository->getMysql()->getAll(self::TABELA);
    }

    private function atualizar()
    {
        if($this->ProdutosRepository->updateProduto($this->dados['id'], $this->dadosCorpoRequest) > 0){
            $this->ProdutosRepository->getMySQL()->getDb()->commit();
            return ConstantesGenericasUtil::MSG_ATUALIZADO_SUCESSO;
        }

        $this->ProdutosRepository->getMySql()->getDb()->rollBack();
        throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_NAO_AFETADO);
    }

    private function cadastrar()
    {
        if($this->dadosCorpoRequest){
            if ($this->ProdutosRepository->inserir($this->dadosCorpoRequest) > 0) {
                $idInserido = $this->ProdutosRepository->getMySQL()->getDb()->lastInsertId();
                $this->ProdutosRepository->getMySQL()->getDb()->commit();
                return ConstantesGenericasUtil::MSG_INSERIDO_SUCESSO;
            }
            $this->ProdutosRepository->getMySql()->getDb()->rollBack();
        }

        throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
    }

    private function deletar()
    {
        return $this->ProdutosRepository->getMysql()->delete(self::TABELA, $this->dados['id']);
    }


}