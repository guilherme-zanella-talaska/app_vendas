<?php

namespace Service;

use Repository\ClientesRepository;
use InvalidArgumentException;
use Util\ConstantesGenericasUtil;

Class ClientesService
{

    public const TABELA = 'clientes';
    public const RECURSOS_GET = ['listar', 'listar_vendas'];
    public const RECURSOS_DELETE = ['deletar'];
    public const RECURSOS_PUT = ['atualizar'];
    public const RECURSOS_POST = ['cadastrar'];

    private $dados;
    private $dadosCorpoRequest;
    private $ClientesRepository;

    public function __construct($dados = [])
    {
        $this->dados = $dados;
        $this->ClientesRepository = new ClientesRepository();
    }

    public function setDadosRequest($dados)
    {
        $this->dadosCorpoRequest = $dados;
    }


    public function validarGet()
    {
        $retorno = null;
        $recurso = $this->dados['recurso'];
      
        if (in_array($recurso, self::RECURSOS_GET, true) && $recurso != 'listar_vendas') {
            $retorno = $this->dados['id'] > 0 ? $this->getOneByKey() : $this->$recurso();
        }elseif($recurso == 'listar_vendas'){
            return $this->ClientesRepository->listar_vendas($this->dados['id']);
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
            
            if ($this->ClientesRepository->inserir($this->dadosCorpoRequest) > 0) {
                
                $idInserido = $this->ClientesRepository->getMySQL()->getDb()->lastInsertId();
                $this->ClientesRepository->getMySQL()->getDb()->commit();
                return ConstantesGenericasUtil::MSG_INSERIDO_SUCESSO;
            }
            $this->ClientesRepository->getMySql()->getDb()->rollBack();
        }

        throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
    }

    private function atualizar()
    {

        if($this->dadosCorpoRequest){
           
            if($this->ClientesRepository->atualizar($this->dados['id'], $this->dadosCorpoRequest) > 0){
                $this->ClientesRepository->getMySQL()->getDb()->commit();
                return ConstantesGenericasUtil::MSG_ATUALIZADO_SUCESSO;
            }else{
                $this->ClientesRepository->getMySql()->getDb()->rollBack();
            }
        }else{
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }

    }

    private function deletar()
    {
        return $this->ClientesRepository->getMysql()->delete(self::TABELA, $this->dados['id']);
    }

}