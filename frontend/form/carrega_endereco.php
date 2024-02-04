<?php

    $cep = !empty($_GET['cep']) ? $_GET['cep'] : 0;

    $curl = curl_init();
    $url_api = "https://viacep.com.br/ws/".$cep."/json/";

    curl_setopt_array($curl, [
        CURLOPT_URL            => $url_api,
        CURLOPT_CUSTOMREQUEST  => "GET",
        CURLOPT_RETURNTRANSFER => true,
    ]);

    $response = curl_exec($curl);

    if($response === false){
       echo null;
    }else{

        $resposta = json_decode($response);
        
        $logradouro = '';
        if(!empty($resposta->logradouro)){
            $logradouro = $resposta->logradouro.", ";
        }
        $cidade = '';
        if(!empty($resposta->localidade)){
            $cidade = $resposta->localidade.", ";
        }
        $uf = '';
        if(!empty($resposta->uf)){
            $uf = $resposta->uf;
        }

        $endereco = $logradouro."".$cidade."".$uf;
        echo json_encode($endereco);
    }


?>