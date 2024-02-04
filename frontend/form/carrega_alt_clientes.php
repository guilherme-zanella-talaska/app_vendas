<?php

    $id = !empty($_GET['id']) ? $_GET['id'] : 0;

    $curl = curl_init();
    $url_api = "http://localhost/app_vendas/backend/www/clientes/listar/".$id."";

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
        CURLOPT_HTTPHEADER     => $headers,
    ]);

    $response = curl_exec($curl);
    
    if($response === false){
       echo null;
    }else{

        $resposta = json_decode($response);
        $array = $resposta->resposta;

        $array_dados = array(
            'id'             => $array->id,
            'nome'           => $array->nome,
            'cpf'            => $array->cpf,
            'endereco'       => $array->endereco,
            'cep'            => $array->cep,
            'email'          => $array->email,
            'status'         => $array->status,
        );
   
        echo json_encode($array_dados);
    }


?>