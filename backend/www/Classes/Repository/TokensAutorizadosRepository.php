<?php

namespace Repository;

use DB\MySQL;
use InvalidArgumentException;
use Util\ConstantesGenericasUtil;

class TokensAutorizadosRepository{

    private $MySql;
    public const TABELA = "tokens_autorizados";

    public function __construct(){
        $this->MySql = new MySql();
    }

    public function validarToken($token)
    {
        $token = str_replace([' ', 'Bearer'], '', $token);

        if($token){
            
            $consultaToken = "
                SELECT
                    id
                FROM
                    ".self::TABELA."
                WHERE
                    token = :token
                AND
                    status = :status
            ";
       
            $stmt = $this->getMySQL()->getDb()->prepare($consultaToken);
            $stmt->bindValue(':token', $token);
            $stmt->bindValue(':status', ConstantesGenericasUtil::SIM);
            $stmt->execute();

            if($stmt->rowCount() !== 1){
                header('HTTP/1.1 401 Unauthorized');
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_TOKEN_VAZIO);
            }

        }else{
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_TOKEN_VAZIO);
        }
    }

    public function getMysql(){
        return $this->MySql;
    }

}


?>