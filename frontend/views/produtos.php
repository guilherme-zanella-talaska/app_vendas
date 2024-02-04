<?php

require_once '../form/realizarLogin.php';
verificarSessao();

echo"
<!DOCTYPE html>
<html lang='pt-br'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Produtos - Vendas</title>
        <link rel='icon' href='../assets/img/favicon.ico'>
        <link rel='stylesheet' href='../assets/css/crud.css'>
        <link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css'>
    </head>
    <body>

        <div class='navbar'>
            <a class='title'>Cadastro de Produtos</a>

            <a href='menu.php' class='right'>
                <i class='small material-icons'>arrow_back</i>
            </a>

            <a onclick=\"addButton();\" class='right modal-trigger'>
                <i class='small material-icons'>add_circle</i>
            </a>

            <input type='text' placeholder='Filtro rápido' id='filtro_text' onkeyup=\"filterTable('dataTable', this.id);\">
        </div>

        <div id='modal1' class='modal'>
        
            <div class='modal-content top'>
                <p class='top-modal'>Cadastro de Produtos</p>
            </div>

            <div class='row'>

                <form method='POST' class='col s12' action=\"../form/Produtos.php\">

                    <input type='hidden' name='alt_id' id='alt_id' value=''>
                    <input type='hidden' name='cadastrar' id='cadastrar' value=''>

                    <div class='input-field col s12'>
                        <input type='text' name='add_descricao' id='add_descricao' class='validate' autocomplete='off' required>
                        <label for='first_name'>Descrição do produto</label>
                    </div>

                    <div class='input-field col s12'>
                        <input type='number' step='any' name='add_quantidade' id='add_quantidade' class='validate' autocomplete='off' required>
                        <label for='first_name'>Quantidade no estoque</label>
                    </div>

                    <div class='input-field col s12'>
                        <input type='number' step='any' name='valor_unitario' id='valor_unitario' class='validate' autocomplete='off' required>
                        <label for='first_name'>Valor unitário (R$)</label>
                    </div>

                    <div class='col s12'>
                        <label>Status</label>
                        <select class='browser-default' name='add_status' id='add_status' class='validate' required>
                            <option value=''>Selecione o status</option>
                            <option value='1'>Ativo</option>
                            <option value='0'>Inativo</option>
                        </select>
                    </div>
                </div>

                <div class='modal-footer'>
                    <button class='btn waves-effect waves right' style='background-color:#0069b4;' type='submit' name='btn_add' id='btn_add' value='add'>
                        Salvar
                        <i class='material-icons right'>save</i>
                    </button>
                </div>
            </form>
        </div>

        <table class'responsive-table' id='dataTable'>
            <thead>
                <tr>
                    <th style='text-align:left;'>Descrição</th>
                    <th style='text-align:center;'>Quantidade</th>
                    <th style='text-align:center;'>Preço</th>
                    <th style='text-align:center;'>Status</th>
                    <th style='text-align:center;'>Ações</th>
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
                listaProdutos();
            });";
            if(isset($_GET['sucesso'])){
                echo"
                    telafim(1, '".$_GET['sucesso']."', 'produtos.php');
                ";
            }elseif(isset($_GET['erro'])){
                echo"
                    telafim(2, '".$_GET['erro']."', 'produtos.php');
                ";
            }
            echo"
        </script>

    </body>
</html>
";

?>