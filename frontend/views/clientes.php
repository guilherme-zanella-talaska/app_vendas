<?php

require_once '../form/realizarLogin.php';
verificarSessao();

echo"
<!DOCTYPE html>
<html lang='pt-br'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Clientes - Vendas</title>
        <link rel='icon' href='../assets/img/favicon.ico'>
        <link rel='stylesheet' href='../assets/css/crud.css'>
        <link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css'>
    </head>
    <body>
            
        <div class='navbar'>

            <a class='title'>Cadastro de Clientes</a>

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
                <p class='top-modal'>Cadastro de Clientes</p>
            </div>

            <div class='row'>

                <form method='POST' class='col s12' action='../form/Clientes.php'>

                    <input type='hidden' name='alt_id' id='alt_id' value=''>
                    <input type='hidden' name='cadastrar' id='cadastrar' value=''>

                    <div class='input-field col s6'>
                        <input type='text' name='add_nome' id='add_nome' class='validate' autocomplete='off' required>
                        <label for='add_nome'>Nome</label>
                    </div>

                    <div class='input-field col s6'>
                        <input type='text' pattern='[0-9]{11}' name='add_cpf' id='add_cpf' class='validate' autocomplete='off' oninput=\"this.value = this.value.replace(/[^0-9]/g, '');\" required>
                        <label for='add_cpf'>Cpf</label>
                    </div>

                    <div class='input-field col s6'>
                        <input type='text' pattern='[0-9]{8}' name='add_cep' id='add_cep' class='validate' autocomplete='off' onchange=\"setEndereco(this.value);\" oninput=\"this.value = this.value.replace(/[^0-9]/g, '');\" required>
                        <label for='add_cep'>Cep</label>
                    </div>

                    <div class='input-field col s6'>
                        <input type='text' name='add_endereco' id='add_endereco' class='validate' autocomplete='off' required>
                        <label for='add_endereco'>Endereço</label>
                    </div>

                    <div class='input-field col s12'>
                        <input type='email' name='add_email' id='add_email' class='validate' autocomplete='off' required>
                        <label for='add_email'>E-mail</label>
                    </div>

                    <div class='col s12'>
                        <label>Status</label>
                        <select class='browser-default' name='add_status' id='add_status' class='validate' required>
                            <option value=''>Selecione o status</option>
                            <option value='1'>Ativo</option>
                            <option value='0'>Inativo</option>
                        </select>
                    </div>
                    <div class='modal-footer'>
                        <button class='btn waves-effect waves right' style='background-color:#0069b4;' type='submit' name='btn_add' id='btn_add' value='add'>
                            Salvar
                            <i class='material-icons right'>save</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <table class='responsive-table' id='dataTable'>
            <thead>
                <tr>
                    <th style='text-align:left;'>Nome</th>
                    <th style='text-align:left;'>E-mail</th>
                    <th style='text-align:center;'>Cpf</th>
                    <th style='text-align:center;'>Cep</th>
                    <th style='text-align:left;'>Endereço</th>
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
                listaClientes();
            });";
            if(isset($_GET['sucesso'])){
                echo"
                    telafim(1, '".$_GET['sucesso']."', 'clientes.php');
                ";
            }elseif(isset($_GET['erro'])){
                echo"
                    telafim(2, '".$_GET['erro']."', 'clientes.php');
                ";
            }
            echo"
        </script>

    </body>
</html>
";

?>