<?php
  
    if(isset($_POST['cadastrar']) && $_POST['add'] == 'add'){
        cadastrar();
    }elseif(isset($_POST['cadastrar']) && $_POST['btn_add'] == 'alt'){
        atualizar();
    }elseif(isset($_GET['listar']) && $_GET['listar'] == 1){
        listar();
    }elseif(isset($_POST['deletar'])){
        deletar();
    }

    function listar()
    {
        $curl = curl_init();
        $url_api = "http://localhost/app_vendas/backend/www/formas_pagamento/listar";

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
    
    function cadastrar()
    {
        
        $descricao      = !empty($_POST['add_descricao'])     ? $_POST['add_descricao']          : '';
        $qtd_parcelas   = !empty($_POST['add_qtd_parcelas'])  ? (int)$_POST['add_qtd_parcelas']  : 0;
        $status         = !empty($_POST['add_status'])        ? (int)$_POST['add_status']        : '';

        $dados = array(
            'descricao'     => $descricao,
            'qtd_parcelas'  => $qtd_parcelas,
            'status'        => $status
        );

        $data = json_encode($dados);
   
        $curl = curl_init();
        $url_api = "http://localhost/app_vendas/backend/www/formas_pagamento/cadastrar";

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
            header("Location: ../views/formas_pagamento.php?erro=".urlencode('Erro ao executar a requisição CURL!')."");
            exit;

        }else{

            $response_decode = json_decode($response);
            $tipo = $response_decode->tipo;

            if($tipo == 'sucesso'){
                curl_close($curl);
                header("Location: ../views/formas_pagamento.php?sucesso=".urlencode('Forma de pagamento inserida com sucesso!')."");
                exit;
            }else{
                curl_close($curl);
                header("Location: ../views/formas_pagamento.php?erro=".urlencode('Ocorreu um erro!')."");
                exit;
            }

        }
    }

    function deletar()
    {
        $id = !empty($_POST['id']) ? (int)$_POST['id'] : 0;

        if(!empty($id)){
        
            $curl = curl_init();
            $url_api = "http://localhost/app_vendas/backend/www/formas_pagamento/deletar/".$id."";
    
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

            header("Location: ../views/formas_pagamento.php?sucesso=".$resp->resposta."");
            exit;

        }else{
            header("Location: ../views/formas_pagamento.php?erro='Id inexistente!'");
            exit;
        }
       
    } 

    function atualizar()
    {

        $id             = !empty($_POST['alt_id'])            ? (int)$_POST['alt_id']            : '';
        $descricao      = !empty($_POST['add_descricao'])     ? $_POST['add_descricao']          : '';
        $qtd_parcelas   = !empty($_POST['add_qtd_parcelas'])  ? (int)$_POST['add_qtd_parcelas']  : 0;
        $status         = !empty($_POST['add_status'])        ? (int)$_POST['add_status']        : 0;

        $dados = array(
            'id'            => $id,
            'descricao'     => $descricao,
            'qtd_parcelas'  => $qtd_parcelas,
            'status'        => $status
        );

        $data = json_encode($dados);
   
        $curl = curl_init();
        $url_api = "http://localhost/app_vendas/backend/www/formas_pagamento/atualizar/".$id."";

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

        if ($response == false){
            
            curl_close($curl);
            header("Location: ../views/formas_pagamento.php?erro=".urlencode('Erro ao executar a requisição CURL!')."");
            exit;

        }else{

            $response_decode = json_decode($response);
            $tipo = $response_decode->tipo;

            if($tipo == 'sucesso'){
                curl_close($curl);
                header("Location: ../views/formas_pagamento.php?sucesso=".urlencode('Forma de pagamento atualizada com sucesso!')."");
                exit;
            }else{
                curl_close($curl);
                header("Location: ../views/formas_pagamento.php?erro=".urlencode('Ocorreu um erro!')."");
                exit;
            }
        }
    }

?>
    