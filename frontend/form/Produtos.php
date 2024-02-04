<?php
    
    if(isset($_GET['listar']) && $_GET['listar'] == 1){
        listar();
    }elseif(isset($_POST['deletar'])){
        deletar();
    }elseif(isset($_POST['cadastrar']) && $_POST['add'] == 'add'){
        cadastrar();
    }elseif(isset($_POST['alt_id']) && $_POST['btn_add'] == 'alt'){
        atualizar();
    }
    
    function listar(){

        $curl = curl_init();
        $url_api = "http://localhost/app_vendas/backend/www/produtos/listar";
    
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

    function deletar(){

        $id = !empty($_POST['id']) ? $_POST['id'] : 0;
   
        if(!empty($id)){
        
            $curl = curl_init();
            $url_api = "http://localhost/app_vendas/backend/www/produtos/deletar/".$id."";
    
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

            header("Location: ../views/produtos.php?sucesso=".$resp->resposta."");
            exit;
        }
    }
    
    function cadastrar(){

        $descricao      = !empty($_POST['add_descricao'])     ? $_POST['add_descricao']          : '';
        $quantidade     = !empty($_POST['add_quantidade'])    ? number_format($_POST['add_quantidade'], 2, '.', ',')  : 0;
        $valor          = !empty($_POST['valor_unitario'])    ? number_format($_POST['valor_unitario'], 2, '.', ',')  : 0;
        $status         = !empty($_POST['add_status'])        ? (int)$_POST['add_status']        : '';

        $dados = array(
            'descricao'     => $descricao,
            'quantidade'    => $quantidade,
            'valor'         => $valor,
            'status'        => $status
        );


        $data = json_encode($dados);

        $curl = curl_init();
        $url_api = "http://localhost/app_vendas/backend/www/produtos/cadastrar";

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
            header("Location: ../views/produtos.php?erro=".urlencode('Erro ao executar a requisição CURL!')."");
            exit;

        }else{

            $response_decode = json_decode($response);
            $tipo = $response_decode->tipo;

            if($tipo == 'sucesso'){
                curl_close($curl);
                header("Location: ../views/produtos.php?sucesso=".urlencode('Produto inserido com sucesso!')."");
                exit;
            }else{
                curl_close($curl);
                header("Location: ../views/produtos.php?erro=".urlencode('Ocorreu um erro!')."");
                exit;
            }

        }
    }

    function atualizar(){

        $id               =  !empty($_POST['alt_id'])         ? $_POST['alt_id']            : 0;
        $descricao        =  !empty($_POST['add_descricao'])  ? $_POST['add_descricao']     : '';
        $quantidade       =  !empty($_POST['add_quantidade']) ? number_format($_POST['add_quantidade'], 2, '.', ',')    : ''; 
        $valor_unitario   =  !empty($_POST['valor_unitario']) ? number_format($_POST['valor_unitario'], 2, '.', ',')    : '';
        $status           =  !empty($_POST['add_status'])     ? $_POST['add_status']        : '';

        $dados = array(
            'id'                => $id,
            'descricao'         => $descricao,
            'quantidade'        => $quantidade,
            'valor'             => $valor_unitario,
            'status'            => $status
        );

        $data = json_encode($dados);
        $curl = curl_init();
        $url_api = "http://localhost/app_vendas/backend/www/produtos/atualizar/".$id."";

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
        header("Location: ../views/produtos.php?sucesso=".urlencode('Produto atualizado com sucesso!')."");
        exit;
    }
?>