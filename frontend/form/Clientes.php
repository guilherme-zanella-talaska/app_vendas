<?php

    if(isset($_GET['listar']) && $_GET['listar'] == 1){
        listar();
    }elseif(isset($_POST['cadastrar']) && $_POST['add'] == 'add'){
        cadastrar();
    }elseif(isset($_POST['deletar'])){
        deletar();
    }elseif(isset($_POST['btn_add']) && $_POST['btn_add'] == 'alt'){
        atualizar();
    }elseif(isset($_GET['listar_vendas']) && $_GET['listar_vendas'] == 1){
        $id_cliente = (int)$_GET['id_cliente'];
        listarVendas($id_cliente);
    }

    function listar()
    {

        $curl = curl_init();
        $url_api = "http://localhost/app_vendas/backend/www/clientes/listar";
    
        if(empty($_SESSION['token'])){
            session_start();
        }
    
        $headers = [
            "Authorization: ".$_SESSION['token'].""
        ];
    
        curl_setopt_array($curl, [
            CURLOPT_URL            => $url_api,
            CURLOPT_CUSTOMREQUEST  => "GET",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => $headers
        ]);
    
        $response = curl_exec($curl);
        
        if($response === false){
           echo null;
        }else{
    
            $resposta = json_decode($response);
            $array = $resposta->resposta;
            $array_dados = [];
    
            $i = 0;
            foreach ($array as $arr) {
                $array_dados[$i] = $arr;
                $i++;
            }
            
            echo json_encode($array_dados);
        }
    }

    function listarVendas($id)
    {

        $curl = curl_init();
        $url_api = "http://localhost/app_vendas/backend/www/clientes/listar_vendas/".$id."";
    
        if(empty($_SESSION['token'])){
            session_start();
        }
    
        $headers = [
            "Authorization: ".$_SESSION['token'].""
        ];
    
        curl_setopt_array($curl, [
            CURLOPT_URL            => $url_api,
            CURLOPT_CUSTOMREQUEST  => "GET",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => $headers
        ]);
    
        $response = curl_exec($curl);
    
        if($response === false){
           echo null;
        }else{
            $resposta = json_decode($response);
            $dados = $resposta->resposta;
            $valores = array();
            foreach ($dados as $key => $value) {
                $valores[$key] = $value;
            }

            echo json_encode($valores);
    
        }
    }

    function cadastrar()
    {

        $nome       =  !empty($_POST['add_nome'])       ? $_POST['add_nome']          : ''; 
        $cpf        =  !empty($_POST['add_cpf'])        ? $_POST['add_cpf']           : '';
        $cep        =  !empty($_POST['add_cep'])        ? $_POST['add_cep']           : '';
        $endereco   =  !empty($_POST['add_endereco'])   ? $_POST['add_endereco']      : '';
        $email      =  !empty($_POST['add_email'])      ? $_POST['add_email']         : '';
        $status     =  !empty($_POST['add_status'])     ? (int)$_POST['add_status']   : '';

        $dados = array(
            'nome'      => $nome,
            'cpf'       => $cpf,
            'cep'       => $cep,
            'endereco'  => $endereco,
            'email'     => $email,
            'status'    => $status
        );

        $data = json_encode($dados);
   
        $curl = curl_init();
        $url_api = "http://localhost/app_vendas/backend/www/clientes/cadastrar";

        if(empty($_SESSION['token'])){
            session_start();
        }
    
        $headers = [
            "Authorization: ".$_SESSION['token'].""
        ];
    
        curl_setopt_array($curl, [
            CURLOPT_URL            => $url_api,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_POSTFIELDS     => $data
        ]);
    
        $response = curl_exec($curl);

        if ($response == false){
            curl_close($curl);
            header("Location: ../views/clientes.php?erro=".urlencode('Erro ao executar a requisição CURL!')."");
            exit;
        }else{

            $response_decode = json_decode($response);
            $tipo = $response_decode->tipo;

            if($tipo == 'sucesso'){
                curl_close($curl);
                header("Location: ../views/clientes.php?sucesso=".urlencode('Cliente inserido com sucesso!')."");
                exit;
            }else{
                curl_close($curl);
                header("Location: ../views/clientes.php?erro=".urlencode('Ocorreu um erro!')."");
                exit;
            }
        }
    }

    function deletar()
    {

        $id = !empty($_POST['id']) ? (int)$_POST['id'] : 0;

        if(!empty($id)){
        
            $curl = curl_init();
            $url_api = "http://localhost/app_vendas/backend/www/clientes/deletar/".$id."";
    
            if(empty($_SESSION['token'])){
                session_start();
            }
        
            $headers = [
                "Authorization: ".$_SESSION['token'].""
            ];
        
            curl_setopt_array($curl, [
                CURLOPT_URL            => $url_api,
                CURLOPT_CUSTOMREQUEST  => "DELETE",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER     => $headers,
            ]);
        
            $response = curl_exec($curl);
            $resp = json_decode($response);
            curl_close($curl);

            header("Location: ../views/clientes.php?sucesso=".$resp->resposta."");
            exit;
        }
    }

    function atualizar()
    {
       
        $id         =  !empty($_POST['alt_id'])         ? $_POST['alt_id']            : 0;
        $nome       =  !empty($_POST['add_nome'])       ? $_POST['add_nome']          : ''; 
        $cpf        =  !empty($_POST['add_cpf'])        ? $_POST['add_cpf']           : '';
        $cep        =  !empty($_POST['add_cep'])        ? $_POST['add_cep']           : '';
        $endereco   =  !empty($_POST['add_endereco'])   ? $_POST['add_endereco']      : '';
        $email      =  !empty($_POST['add_email'])      ? $_POST['add_email']         : '';
        $status     =  !empty($_POST['add_status'])     ? $_POST['add_status']        : 0;

        $dados = array(
            'nome'      => $nome,
            'cpf'       => $cpf,
            'cep'       => $cep,
            'endereco'  => $endereco,
            'email'     => $email,
            'status'    => $status
        );

        $data = json_encode($dados);
        $curl = curl_init();
        $url_api = "http://localhost/app_vendas/backend/www/clientes/atualizar/".$id."";

        if(empty($_SESSION['token'])){
            session_start();
        }
    
        $headers = [
            "Authorization: ".$_SESSION['token'].""
        ];
    
        curl_setopt_array($curl, [
            CURLOPT_URL            => $url_api,
            CURLOPT_CUSTOMREQUEST  => "PUT",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_POSTFIELDS     => $data
        ]);
    
        $response = curl_exec($curl);
   
        $response_decode = json_decode($response);
        $tipo = $response_decode->tipo;
 
        curl_close($curl);
        header("Location: ../views/clientes.php?sucesso=".urlencode('Cliente atualizado com sucesso!')."");
        exit;
    }

?>