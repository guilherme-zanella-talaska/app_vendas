<?php

namespace Validator;

use Util\ConstantesGenericasUtil;
use Util\JsonUtil;
use Repository\TokensAutorizadosRepository;
use Service\UsuariosService;
use Service\ProdutosService;
use Service\VendasService;
use Service\FormasPagamentoService;
use Service\ClientesService;
use InvalidArgumentException;

class RequestValidator{

    private $request;
    private $dadosRequest = [];
    private $TokensAutorizadosRepository;

    const GET = 'GET';
    const DELETE = 'DELETE';
    const USUARIOS = 'USUARIOS';
    const FORMAS_PAGAMENTO = 'FORMAS_PAGAMENTO';
    const PRODUTOS = 'PRODUTOS';
    const CLIENTES = 'CLIENTES';
    const VENDAS = 'VENDAS';

    public function __construct($request)
    {
        $this->request = $request;
        $this->TokensAutorizadosRepository = new TokensAutorizadosRepository();
    }

    public function processarRequest()
    {
        
        if(in_array($this->request['metodo'], ConstantesGenericasUtil::TIPO_REQUEST, true)){
            $retorno = $this->direcionarRequest();
        }else{
            $retorno =  mb_convert_encoding(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA, "HTML-ENTITIES", "UTF-8");
        }
    
        return $retorno;
    }

    private function direcionarRequest()
    {
        if($this->request['metodo'] !== self::GET && $this->request['metodo'] !== self::DELETE){
            $this->dadosRequest = JsonUtil::tratarCorpoRequisicaoJson();
        }

        $recursosNaoAutenticados = ['cadastrar', 'listar', 'logar', 'validarTokenAtivo', 'matarSessao'];
     
        if(!in_array($this->request['recurso'], $recursosNaoAutenticados) || $this->request['rota'] !== 'USUARIOS'){
            $this->TokensAutorizadosRepository->validarToken(getallheaders()['Authorization']);
        }

        $metodo = $this->request['metodo'];
   
        return $this->$metodo(); //$this->get();
    }

    private function get()
    {
        $retorno = mb_convert_encoding(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA, "HTML-ENTITIES", "UTF-8");
        if(in_array($this->request['rota'], ConstantesGenericasUtil::TIPO_GET, true)){
            switch($this->request['rota']){
                case self::USUARIOS:
                    $UsuarioService = new UsuariosService($this->request);
                    $retorno = $UsuarioService->validarGet();
                    break;
                case self::FORMAS_PAGAMENTO:
                    $FormasPagamentoService = new FormasPagamentoService($this->request);
                    $retorno = $FormasPagamentoService->validarGet();
                    break;
                case self::PRODUTOS:
                    $ProdutosService = new ProdutosService($this->request);
                    $retorno = $ProdutosService->validarGet();
                    break;
                case self::CLIENTES:
                    $ClientesService = new ClientesService($this->request);
                    $retorno = $ClientesService->validarGet();
                    break;
                default:
                    throw new InvalidArgumentException(mb_convert_encoding(ContantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE, "HTML-ENTITIES", "UTF-8"));
            }      
        }
        return $retorno;
    }

    private function delete()
    {
        $retorno = mb_convert_encoding(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA, "HTML-ENTITIES", "UTF-8");

        if(in_array($this->request['rota'], ConstantesGenericasUtil::TIPO_DELETE, true)){
            switch($this->request['rota']){
                case self::USUARIOS:
                    $UsuarioService = new UsuariosService($this->request);
                    $retorno = $UsuarioService->validarDelete();
                    break;
                case self::FORMAS_PAGAMENTO:
                    $FormasPagamentoService = new FormasPagamentoService($this->request);
                    $retorno = $FormasPagamentoService->validarDelete();
                    break;
                case self::PRODUTOS:
                    $ProdutosService = new ProdutosService($this->request);
                    $retorno = $ProdutosService->validarDelete();
                    break;
                case self::CLIENTES:
                    $ClientesService = new ClientesService($this->request);
                    $retorno = $ClientesService->validarDelete();
                    break;
                default:
                    throw new InvalidArgumentException(mb_convert_encoding(ContantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE, "HTML-ENTITIES", "UTF-8"));
            }      
        }
        return $retorno;
    }

    private function post()
    {
        $retorno = mb_convert_encoding(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA, "HTML-ENTITIES", "UTF-8");
        if(in_array($this->request['rota'], ConstantesGenericasUtil::TIPO_POST, true)){
            switch($this->request['rota']){
                case self::USUARIOS:
                    $UsuarioService = new UsuariosService($this->request);
                    $UsuarioService->setDadosRequest($this->dadosRequest);
                    $retorno = $UsuarioService->validarPost();
                    break;
                case self::FORMAS_PAGAMENTO:
                    $FormasPagamentoService = new FormasPagamentoService($this->request);
                    $FormasPagamentoService->setDadosRequest($this->dadosRequest);
                    $retorno = $FormasPagamentoService->validarPost();
                    break;
                case self::PRODUTOS:
                    $ProdutosService = new ProdutosService($this->request);
                    $ProdutosService->setDadosRequest($this->dadosRequest);
                    $retorno = $ProdutosService->validarPost();
                    break;
                case self::CLIENTES:
                    $ClientesService = new ClientesService($this->request);
                    $ClientesService->setDadosRequest($this->dadosRequest);
                    $retorno = $ClientesService->validarPost();
                    break;
                case self::VENDAS:
                    $VendasService = new VendasService($this->request);
                    $VendasService->setDadosRequest($this->dadosRequest);
                    $retorno = $VendasService->validarPost();
                    break;
                default:
                    throw new InvalidArgumentException(mb_convert_encoding(ContantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE, "HTML-ENTITIES", "UTF-8"));
            }      
        }
        return $retorno;
    }

    private function put()
    {
        $retorno = mb_convert_encoding(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA, "HTML-ENTITIES", "UTF-8");

        if(in_array($this->request['rota'], ConstantesGenericasUtil::TIPO_PUT, true)){
            switch($this->request['rota']){
                case self::USUARIOS:
                    $UsuarioService = new UsuariosService($this->request);
                    $UsuarioService->setDadosRequest($this->dadosRequest);
                    $retorno = $UsuarioService->validarPut();
                    break;
                case self::FORMAS_PAGAMENTO:
                    $FormasPagamentoService = new FormasPagamentoService($this->request);
                    $FormasPagamentoService->setDadosRequest($this->dadosRequest);
                    $retorno = $FormasPagamentoService->validarPut();
                    break;
                case self::PRODUTOS:
                    $ProdutosService = new ProdutosService($this->request);
                    $ProdutosService->setDadosRequest($this->dadosRequest);
                    $retorno = $ProdutosService->validarPut();
                    break;
                case self::CLIENTES:
                    $ClientesService = new ClientesService($this->request);
                    $ClientesService->setDadosRequest($this->dadosRequest);
                    $retorno = $ClientesService->validarPut();
                    break;
                default:
                    throw new InvalidArgumentException(mb_convert_encoding(ContantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE, "HTML-ENTITIES", "UTF-8"));
            }      
        }
        return $retorno;
    }

}