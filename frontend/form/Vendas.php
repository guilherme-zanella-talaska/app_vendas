<?php


    if(isset($_GET['gerar']) && $_GET['gerar'] == 1){
        gerar();
    }

    function gerar(){
        
        $dados    = json_decode(file_get_contents("php://input"), true);
        $venda    = $dados['venda'];
        $produtos = $dados['produtos'];
   

        $data = array(
            "cliente" => $venda[0]["cliente"],
            "pagamento" => $venda[1]["pagamento"],
            "qtd_parcelas" => $venda[2]["qtd_parcelas"],
            "data_lancamento" => date('Y-m-d H:i:s')
        );

        $json = json_encode($data);

        $curl = curl_init();
        $url_api = "http://localhost/app_vendas/backend/www/vendas/cadastrar";

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
            CURLOPT_POSTFIELDS     => $json
        ]);

        $response = curl_exec($curl);
    
        if ($response == false){
            curl_close($curl);
            echo 0;
        }else{
           
            $response_decode = json_decode($response);
            $tipo = $response_decode->tipo;
            $id = $response_decode->resposta->id_inserido;
            
            if($tipo == 'sucesso'){
                curl_close($curl);
                inserirProdutos($id, $produtos);
            }else{
                curl_close($curl);
                echo 0;
            }
        }
    }

    function inserirProdutos($id, $produtos){

   
        $id_venda = $id;
        $data = array();
        foreach ($produtos as $item) {
            $data[] = array(
                "id_venda" => $id_venda,
                "id_produto" => $item["id"],
                "quantidade" => $item["quantidade"]
            );
        }

        $json = json_encode($data);
        $curl = curl_init();
        $url_api = "http://localhost/app_vendas/backend/www/vendas/cadastrar_produtos";

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
            CURLOPT_POSTFIELDS     => $json
        ]);

        $response = curl_exec($curl);

        if ($response == false){
            curl_close($curl);
            echo 0;
        }else{

            $response_decode = json_decode($response);
            $tipo = $response_decode->tipo;
         
            if($tipo == 'sucesso'){
                curl_close($curl);
                echo 1;
            }else{
                curl_close($curl);
                echo 0;
            }
        }
    }

?>