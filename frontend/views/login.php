<?php   

require_once '../form/realizarLogin.php';
verificarSessao();

echo"
<!DOCTYPE html>
<html lang='pt-br'>

    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Login - Vendas</title>
        <link rel='icon' href='../assets/img/favicon.ico'>
        <link rel='stylesheet' href='../assets/css/login.css'>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css'>
        <link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
    </head>

    <body>
        <div class='login-container'>
            <div class='login-top'>
                <p class='title-form'>Sistema de vendas</p>
                <p class='title-screen'>Login</p>
            </div>

            <form class='login-form' method='POST' action='../form/realizarLogin.php'>

                <input type='hidden' name='makeLogin' value=''>

                <div class='row'>
                    <div class='col s12 input-field form-group'>
                        <i class='material-icons prefix'>account_circle</i>
                        <input type='text' id='username' name='username' autocomplete='off' required>
                        <label for='username'>Usuário</label>
                    </div>

                    <div class='col s12 input-field form-group'>
                        <i class='material-icons prefix'>vpn_key</i>
                        <input type='password' id='password' name='password' autocomplete='off' required>
                        <label for='password'>Senha</label>
                    </div>
                </div>

                <div class='form-group'>
                    <button type='submit' id='btn_login' name='btn_login'>Entrar</button>
                </div>

                <div class='form-group' onclick=\"window.open('cad_usuarios.php', '_self');\">
                    <button type='button'>Cadastrar-se</button>
                </div>

                <div class='form-group'>
                    <img src='../assets/img/zucchetti_blue.png'>
                </div>
            </form>
        </div>

        <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js'></script>
        <script src='../assets/js/funcoes.js'></script>

        <script>
            $(document).ready(function() {
                M.updateTextFields();
            });";
            if(isset($_GET['sucesso'])){
                echo"
                    telafim(1, '".$_GET['sucesso']."', 'login.php');
                ";
            }elseif(isset($_GET['erro'])){
                echo"
                    telafim(2, '".$_GET['erro']."', 'login.php');
                ";
            }
            echo"
        </script>
    </body>
</html>
";

?>