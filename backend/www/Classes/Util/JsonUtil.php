<?php


namespace Util;

use InvalidArgumentException;
use JsonException;
use Util\ConstantesGenericasUtil;

class JsonUtil{

    public function processarArrayRetorno($retorno)
    {
        $dados = [];
        $dados[ConstantesGenericasUtil::TIPO] = ConstantesGenericasUtil::TIPO_ERRO;

        if(is_array($retorno) && count($retorno) > 0 || strlen($retorno) > 10){
            $dados[ConstantesGenericasUtil::TIPO] = ConstantesGenericasUtil::TIPO_SUCESSO;
            $dados[ConstantesGenericasUtil::RESPOSTA] = $retorno;
        }

        $this->retornarJson($dados);
    }

    public static function tratarCorpoRequisicaoJson()
    {

        try{
            $postJson = json_decode(file_get_contents('php://input'), true);
        }catch(JsonException $exeption){
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERR0_JSON_VAZIO);
        }

        if(is_array($postJson) && count($postJson) > 0){
           
            return $postJson;
        }

    }

    private function retornarJson($json)
    {
        header('Content-Type: application/json');    
        header('Cache-Control: no-chache, no-store, must-revalidate');    
        header('Access-Control-Allow_Methods: GET, POST, PUT, DELETE');    
        echo json_encode($json);
        exit;
    }   

}











?>