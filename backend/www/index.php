<?php

use Validator\RequestValidator;
use Util\RotasUtil;
use Util\ConstantesGenericasUtil;
use Util\JsonUtil;

include 'bootstrap.php';

try {
    $RequestValidator = new RequestValidator(\Util\RotasUtil::getRotas());
    $retorno = $RequestValidator->processarRequest();
    
    $JsonUtil = new JsonUtil();
    $JsonUtil->processarArrayRetorno($retorno);

} catch (Exception $exception) {

    echo json_encode([
        ConstantesGenericasUtil::TIPO => ConstantesGenericasUtil::TIPO_ERRO,
        ConstantesGenericasUtil::RESPOSTA => $exception->getMessage()
    ]);

    exit;
}
