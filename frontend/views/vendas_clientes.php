<?php

require_once '../form/realizarLogin.php';
verificarSessao();

echo"
<!DOCTYPE html>
<html lang='pt-br'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Vendas - Lista de vendas</title>
        <link rel='icon' href='../assets/img/favicon.ico'>
        <link rel='stylesheet' href='../assets/css/crud.css'>
        <link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css'>
    </head>
    <body>

        <div class='navbar'>
            <a class='title'>Lista de vendas realizadas</a>

            <a href='clientes.php' class='right'>
                <i class='small material-icons'>arrow_back</i>
            </a>

            <input type='text' placeholder='Filtro rápido' id='filtro_text' onkeyup=\"filterTable('dataTable', this.id);\">
        </div>

        <table class'responsive-table' id='dataTable'>
            <thead>
                <tr>
                    <th style='text-align:left;'>Cliente</th>
                    <th style='text-align:center;'>Forma de pagamento</th>
                    <th style='text-align:center;'>Parcelas</th>
                    <th style='text-align:center;'>Valor</th>
                </tr>
            </thead>
            <tbody id='corpo'>
            
            </tbody>
        </table>

        <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js'></script>
        <script src='../assets/js/funcoes.js'></script>
        <script>  

            $(document).ready(function(){
                $('.modal').modal();
                $('.sidenav').sidenav();
                listaVendas(".$_GET['id'].");
            });

        </script>

    </body>
</html>
";

?>