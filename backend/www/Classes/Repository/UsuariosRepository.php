<?php

namespace Repository;

use DB\MySQL;
use InvalidArgumentException;
use Util\ConstantesGenericasUtil;

class UsuariosRepository{

    private $MySql;
    public const TABELA = "usuarios";
    public const TABELA_TOKEN = "tokens_autorizados";

    public function __construct(){
        $this->MySql = new MySQL();
    }

    public function getMysql(){
        return $this->MySql;
    }

    public function insertUser($login, $email, $senha)
    {
        $query = 'INSERT INTO ' . self::TABELA . ' (login, email, senha) VALUES (:login, :email, :senha)';
        $this->MySql->getDb()->beginTransaction();
        $stmt = $this->MySql->getDb()->prepare($query);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', password_hash($senha, PASSWORD_DEFAULT));
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function authUser($dados, $dados_login)
    {
      
        $id_usuario = 0;
        foreach($dados_login as $data){
        
            if($data['login'] == $dados['username'] && (password_verify($dados['password'], $data['senha']))){

                $id_usuario = $data['id'];

                //DESATIVAR OUTROS TOKENS DO USUÁRIO
                $query = "UPDATE ".self::TABELA_TOKEN." SET status = :status WHERE id_cad_usuarios = :id";
                $this->MySql->getDb()->beginTransaction();
                $stmt = $this->MySql->getDb()->prepare($query);
                $stmt->bindValue(':status', 'N');
                $stmt->bindParam(':id', $id_usuario);
                $stmt->execute();
                $this->MySql->getDb()->commit();


                $data_atual = date('Y-m-d H:i:s');
                $expired_at = date('Y-m-d H:i:s', strtotime($data_atual . ' + 1 day'));
                $query = 'INSERT INTO ' . self::TABELA_TOKEN . ' (id_cad_usuarios, token, status, created_at, expired_at) VALUES (:id_cad_usuarios, :token, :status, :created_at, :expired_at)';
               
                $this->MySql->getDb()->beginTransaction();
               
                $stmt = $this->MySql->getDb()->prepare($query);
                $stmt->bindParam(':id_cad_usuarios', $id_usuario);
                $token = md5(uniqid());
                $stmt->bindValue(':token', $token);
                $stmt->bindValue(':status', 'S');
                $stmt->bindValue(':created_at', date('Y-m-d H:i:s'));
                $stmt->bindValue(':expired_at', $expired_at);
                $stmt->execute();
                return ['token' => $token, 'rowCount' => $stmt->rowCount(), 'id_usuario' => $id_usuario];
            }
        }
        return 0;
    }

    public function validateToken($dados, $dados_tokens)
    {
     
        $data_atual = date('Y-m-d H:i:s');
        $expired_at = '';
        $status = '';
        $id = '';

        foreach($dados_tokens as $dt){

            if($dados['token'] == $dt['token']){
                $expired_at = $dt['expired_at'];
                $status = $dt['status'];
                $id = $dt['id'];
            }
        }

        if(date('Y-m-d H:i:s', strtotime($data_atual)) >= date('Y-m-d H:i:s', strtotime($expired_at))){
            $query = 'UPDATE ' . self::TABELA_TOKEN . ' SET status = "N" WHERE id = :id';
            $this->MySql->getDb()->beginTransaction();
            $stmt = $this->MySql->getDb()->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return 1;
        }elseif($status == "N"){
            return 1;
        }else{
           return 0;
        }
    }

    public function killSession($dados, $dados_tokens) {
        try {
            $id = null;
            foreach ($dados_tokens as $dt) {
                if ($dados['token'] == $dt['token']) {
                    $id = $dt['id'];
                }
            }
            if ($id !== null) {
                $query = 'UPDATE ' . self::TABELA_TOKEN . ' SET status = "N" WHERE id = :id';
                $this->MySql->getDb()->beginTransaction();
                $stmt = $this->MySql->getDb()->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                return 1;
            } else {
                return 0;
            }
        } catch (Exception $e) {
            return 0;
        }
    }

}

?>