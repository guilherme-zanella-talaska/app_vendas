<?php

    require_once '../form/realizarLogin.php';
    verificarSessao();

    echo"    
    <!DOCTYPE html>
        <html lang='pt-br'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Tela de Vendas</title>
            <link rel='icon' href='../assets/img/favicon.ico'>
            <link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
            <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css'>
            <link rel='stylesheet' href='../assets/css/vendas.css'>
        </head>
        <body>
            <div class='navbar'>
                <a href='menu.php' class='title'><- Voltar ao Menu</a>
            </div>

            <div id='modal1' class='modal'>
        
                <div class='modal-content top'>
                    <p class='top-modal'>Informe os dados da venda:</p>
                </div>

                <div class='row'>
                    <form method='POST' id='formFinalizar'>

                        <input type='hidden' id='tipo' name='tipo' value='1'>
                        <input type='hidden' id='id_forma' name='id_forma' value=''>

                        <div class='col s12' style='margin-bottom:10px;'>
                            <label style='font-weight:bold;'>Lista de clientes</label>
                            <select class='browser-default' style='border-color: #aaa;' name='add_clientes' id='add_clientes' class='validate' required>
                                <option value=''>Selecione um cliente</option>
                            </select>
                        </div>

                        <div class='col s12' style='margin-bottom:10px;>
                            <label style='font-weight:bold; color:#aaa;'>Formas de pagamento</label>
                            <select class='browser-default' style='border-color: #aaa;' name='add_formas_pagamento' id='add_formas_pagamento' onchange=\"campoParcelas(this.value);\" class='validate' required>
                                <option value=''>Selecione uma forma de pagamento</option>
                            </select>
                        </div>

                        <div class='col s12 input-field' id='pay' name='pay' style='display:none;'>
                        </div>

                        <div class='modal-footer' style='margin-top: 20px;'>
                            <button class='btn waves-effect waves right' style='background-color:#0069b4;' type='button' name='btn_add' id='btn_add' value='add' onclick='gerarVenda();'>
                                Finalizar
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        
            <div class='container'>
                <div class='row'>

                    <div class='col s12 m6 cart-container' style='background-color: #fff; margin-bottom:20px;'>
                        <div>
                            <h5 class='title_div_vendas'>Produtos</h5>
                            <hr>
                        </div>

                        <div class='input-field col s12'>
                            <i class='material-icons prefix'>find_in_page</i>
                            <input id='icon_prefix' type='text' class='validate' id='filtro_text' onkeyup=\"filterTable('list_produtos', this.id);\">
                            <label for='icon_prefix'>Pesquisa rápida</label>
                        </div>

                        <div class='table-container responsive-table'>
                            <table class='striped highlight responsive-table' id='list_produtos'>

                                <thead>
                                    <tr>
                                        <th style='text-align:center;'>Código</th>
                                        <th style='text-align:center;'>Nome</th>
                                        <th style='text-align:center;'>Valor</th>
                                        <th style='text-align:center;'>Estoque</th>
                                        <th style='text-align:center;'>Comprar</th>
                                    </tr>
                                </thead>

                                <form id='prod_form' name='form_prod' method='POST' onsubmit='return confirm('Deseja realmente finalizar a compra?');'>
                                    <tbody id='produtos_body'>
                                        
                                    </tbody>
                                </form>
                            </table>
                        </div>
                        
                    </div>
                
                    <div class='col s12 m6 cart-container' style='background-color: #fff; margin-bottom:20px;'>

                        <div>
                            <h5 class='title_div_vendas'>Carrinho</h5>
                            <hr>
                        </div>

                        <div class='input-field col s12'>
                            <i class='material-icons prefix'>add_shopping_cart</i>
                            <input id='icon_prefix_cart' type='text' id='filtro_text_cart' class='validate' onkeyup=\"filterTable('carrinho', this.id);\">
                            <label for='icon_prefix_cart'>Pesquisa rápida...</label>
                        </div>

                        <div class='table-container responsive-table'>
                            <table class='striped highlight responsive-table' id='carrinho'>

                                <thead>
                                    <tr>
                                        <th style='text-align:center;'>Código</th>
                                        <th style='text-align:center;'>Nome</th>
                                        <th style='text-align:center;'>Valor</th>
                                        <th style='text-align:center;'>Qtd.</th>
                                        <th style='text-align:center;'>Devolver</th>
                                    </tr>
                                </thead>

                                <tbody id='carrinho_body'>
                                
                                </tbody>

                            </table>
                        </div>

                    </div>
        
                    <div class='footer col s12' '>
                        <div class='divider_footer'>
                        <h5 class='title_footer' id='total'>Total: R$ 0,00</h5>
                    </div>

                    <img style='margin-top:20px;' src='../assets/img/zucchetti_blue.png'>
                </div>
            </div>

            <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
            <script src='https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js'></script>
            <script src='../assets/js/funcoes.js'></script>
           
            <script>
                $(document).ready(function(){
                    $('.modal').modal();
                    $('.sidenav').sidenav();
                    carregaProdutosVenda();
                    calcularTotal();
                 });";
                if(isset($_GET['sucesso'])){
                    echo"
                        telafim(1, '".$_GET['sucesso']."', 'vendas.php');
                    ";
                }elseif(isset($_GET['erro'])){
                    echo"
                        telafim(2, '".$_GET['erro']."', 'vendas.php');
                    ";
                }
                echo"
            </script>

        </body>
    </html>";

?>
 
