<?php   

require_once '../form/realizarLogin.php';
verificarSessao();

if(isset($_POST['logout'])){
    encerrarSessao();
}
   
echo"
<!DOCTYPE html>
<html lang='pt-br'>

    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Menu - Vendas</title>
        <link rel='icon' href='../assets/img/favicon.ico'>
        <link rel='stylesheet' href='../assets/css/menu.css'>
        <link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css'>
    </head>

    <body>
        <div class='menu-container'>
            <div class='titulo_menu'>
                <p>Seja bem-vindo(a), <b>".$_SESSION['login']."!</b></p>
            </div>

            <div class='titulo_menu'>
                <span>Selecione um módulo:</span>
            </div>

            <button class='menu_item' onclick=\"window.open('vendas.php', '_self');\">
                <img src='../assets/img/vendas.png'>
                <span>Área de vendas (PDV)</span>
            </button>

            <button class='menu_item' onclick=\"window.open('clientes.php', '_self');\">
                <img src='../assets/img/clientes.png'>
                <span>Cadastro de clientes</span>
            </button>

            <button class='menu_item' onclick=\"window.open('produtos.php', '_self');\">
                <img src='../assets/img/cad_produtos.png'>
                <span>Cadastro de produtos</span>
            </button>

            <button class='menu_item' onclick=\"window.open('formas_pagamento.php', '_self');\">
                <img src='../assets/img/pagamento.png'>
                <span>Formas de pagamento</span>
            </button>

            <button type='submit' class='menu_item_logout' id='logout'>
                <img src='../assets/img/sair.png'>
                <span>Sair do sistema</span>
            </button>

            <form method='POST' id='form_encerrar'>
                <input type='hidden' name='logout' value=''>
            </form>

            <div class='form-group' style='margin-top:10%; width:100% !important;'>
                <img src='../assets/img/zucchetti_blue.png'>
            </div>
        </div>
    </body>

    <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
    <script src='../assets/js/funcoes.js'></script>

    <script>";
        if(isset($_GET['sucesso'])){
            echo"
                telafim(1, '".$_GET['sucesso']."', 'menu.php');
            ";
        }
        echo"
        document.getElementById('logout').addEventListener('click', function() {
            if (confirm('Você realmente deseja sair do sistema?')) {
                document.getElementById('form_encerrar').submit();
            }
        });
    </script>
</html>
";

?>