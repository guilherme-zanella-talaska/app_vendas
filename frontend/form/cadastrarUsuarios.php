<?php

    if(isset($_POST['cadUsuarios']))
    {
        validarUsuarioExistente();
    }else
    {
        header("Location: ../views/cad_usuarios.php");
    }

    function validarUsuarioExistente()
    {

        $username   = !empty($_POST['username']) ? $_POST['username'] : '';
        $email      = !empty($_POST['email'])    ? $_POST['email']    : '';
        $password   = !empty($_POST['password']) ? $_POST['password'] : '';

        $array_post = array(
            'login' => $username,
            'email' => $email,
            'senha' => $password,
        );
  
        $curl = curl_init();

        $url_api = "http://localhost/app_vendas/backend/www/usuarios/listar";
    
        curl_setopt_array($curl, [
            CURLOPT_URL            => $url_api,
            CURLOPT_CUSTOMREQUEST  => "GET",
            CURLOPT_RETURNTRANSFER => true,
        ]);

        $response = curl_exec($curl);
        
        if ($response === false){
            curl_close($curl);
            header("Location: ../views/cad_usuarios.php?erro=".urlencode('Erro ao executar a requisição CURL!')."");
            exit;
        }else{
            $decoded_response = json_decode($response);
    
            if($decoded_response === null){
                curl_close($curl);
                header("Location: ../views/cad_usuarios.php?erro=".urlencode('Erro ao decodificar a resposta JSON!')."");
                exit;
            } 
    
            $resposta = $decoded_response->tipo;
            $array_dados = [];
    
            $i = 0;
            foreach($decoded_response->resposta as $r){
               $array_dados['login'][$i] = $r->login;
               $array_dados['email'][$i] = $r->email;
               $i++;
            }

            if(count($array_dados) > 0){
                if(in_array($array_post['login'], $array_dados['login'])){
                    curl_close($curl);
                    header("Location: ../views/cad_usuarios.php?erro=".urlencode('Login já existente!')."");
                    exit;
                }elseif(in_array($array_post['email'], $array_dados['email'])){
                    curl_close($curl);
                    header("Location: ../views/cad_usuarios.php?erro=".urlencode('E-mail já está sendo utilizado!')."");
                    exit;
                }
            }
      
            curl_close($curl);
            cadastrarUsuario($array_post);
        }
    }

    function cadastrarUsuario($dados = [])
    {

        $data = json_encode($dados);

        $curl = curl_init();

        $url_api = "http://localhost/app_vendas/backend/www/usuarios/cadastrar";
        $headers = [
            'Authorization: Bearer 4652ca89-7de7-4612-aed9-7632a43c1c12'
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
            header("Location: ../views/cad_usuarios.php?erro=".urlencode('Erro ao executar a requisição CURL!')."");
            exit;
        }else{

            $response_decode = json_decode($response);
            $tipo = $response_decode->tipo;

            if($tipo == 'sucesso'){
                curl_close($curl);
                header("Location: ../views/cad_usuarios.php?sucesso=".urlencode('Usuário cadastrado com sucesso!')."");
                exit;
            }else{
                curl_close($curl);
                header("Location: ../views/cad_usuarios.php?erro=".urlencode('Ocorreu um erro!')."");
                exit;
            }

        }

       

    }
?>
    