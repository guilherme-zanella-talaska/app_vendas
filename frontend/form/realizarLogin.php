<?php

    if(isset($_POST['makeLogin']))
    {
        login();
    }
    
    function login()
    {
        $username = !empty($_POST['username']) ? $_POST['username'] : '';    
        $password = !empty($_POST['password']) ? $_POST['password'] : '';
    
        $array_post = array(
            'username' => $username,
            'password' => $password
        );
       
        $curl = curl_init();
        $url_api = "http://localhost/app_vendas/backend/www/usuarios/logar";


        curl_setopt_array($curl, [
            CURLOPT_URL            => $url_api,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS     => json_encode($array_post)
        ]);

        $response = curl_exec($curl);
  
        if($response === false){

            curl_close($curl);
            header("Location: ../views/login.php?erro=".urlencode('Erro ao executar a requisição CURL!')."");
            exit;

        }else{

            $response_decode = json_decode($response);

            if($response_decode->tipo == 'sucesso'){
                
                $id = $response_decode->resposta;
                $token = $response_decode->resposta;

                $array_session = array(
                    'id'    =>  $id->id,
                    'login' =>  $username,
                    'token' =>  $token->token
                );

                iniciarSessao($array_session);
            }

            header("Location: ../views/login.php?erro=Usuário ou senha inválidos!");
            exit;
        }
    }

    function iniciarSessao($dados = [])
    {
        if(!isset($_SESSION)){
            session_start();
        }

        $_SESSION['id_usuario'] = $dados['id'];
        $_SESSION['login']      = $dados['login'];
        $_SESSION['token']      = $dados['token'];
 
        header("Location: ../views/menu.php?sucesso=Login realizado com sucesso!");
        exit;
    }

    function verificarSessao() 
    {
        if(!isset($_SESSION)){
            session_start();
        }
        
        $token = $_SESSION['token'];
        
        $array_post = array(
            'token' => $token,
        );

        $curl = curl_init();
      
        $url_api = "http://localhost/app_vendas/backend/www/usuarios/validarTokenAtivo";
  
        curl_setopt_array($curl, [
            CURLOPT_URL            => $url_api,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS     => json_encode($array_post)
        ]);

        $response = curl_exec($curl);
        if($response === false){

            curl_close($curl);
            header("Location: ../views/login.php?erro=".urlencode('Erro ao executar a requisição CURL!')."");
            exit;

        }else{

            $response_decode = json_decode($response);
            
            if($response_decode->resposta == 'Token não autorizado!' && isset($_SESSION['id_usuario'])){
                encerrarSessao();
            }

            $array_autenticados = ['menu.php', 'produtos.php', 'formas_pagamento.php', 'clientes.php', 'vendas.php', 'vendas_clientes.php'];
           

            if (!isset($_SESSION['id_usuario'])) {
                
                if (basename($_SERVER['PHP_SELF']) == 'login.php' || basename($_SERVER['PHP_SELF']) == 'cad_usuarios.php') {
                    return;
                }else{
                    header("Location: ../views/login.php");
                    exit;
                }

            }elseif(isset($_SESSION['id_usuario']) && !in_array(basename($_SERVER['PHP_SELF']), $array_autenticados)){
                
                header("Location: ../views/menu.php");
                exit;
            }
        }

    }

    function encerrarSessao() 
    {

        if(!isset($_SESSION)){
            session_start();
        }

        $array_post = array(
            'token' => $_SESSION['token']
        );

        $curl = curl_init();
        $url_api = "http://localhost/app_vendas/backend/www/usuarios/matarSessao";

        curl_setopt_array($curl, [
            CURLOPT_URL            => $url_api,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS     => json_encode($array_post)
        ]);

        $response = curl_exec($curl);

        if($response === false){

            curl_close($curl);
            header("Location: ../views/login.php?erro=".urlencode('Erro ao executar a requisição CURL!')."");
            exit;

        }else{

            $response_decode = json_decode($response);

            if($response_decode->resposta == 'Usuário deslogado!'){
               session_destroy();
               header("Location: ../views/login.php?sucesso=Logout realizado com sucesso!");
               exit;
            }else{
                header("Location: ../views/login.php?erro=Ops! Ocorreu um erro inesperado!");
                exit;
            }
            
        }
    }

?>