
//------------------------ FORMAS DE PAGAMENTO ----------------------------- //
function listaFormasPagamento() {
  const xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          const retorno = JSON.parse(this.responseText);
          $('#corpo').html('');
          $('#corpo').append(`
          <tr>
            <td colspan='4' style='text-align:center;'>Nenhum registro encontrado!</td>
          </tr>
        `)
          let index = 0;
          retorno.forEach(function(item) {

              if(index === 0){
                $('#corpo').html('');
              }
              index = index + 1;

              let status = parseInt(item.status) === 1 ? 'Ativo' : 'Inativo';
              
              $('#corpo').append(`
              <tr>
                  <td style='text-align:left;'>${item.descricao}</td>
                  <td style='text-align:center;'>${item.qtd_parcelas}x</td>
                  <td style='text-align:center;'>${status}</td>
                  <td style='text-align:center;'> 
                    <form method="POST" action=\"../form/FormaPagamento.php\" onsubmit="return confirm('Tem certeza de que deseja excluir este registro?');">
                      <input type='hidden' name='id' value='${item.id}'>

                      <button class='btn-floating btn-small waves-effect waves-light blue' type='button' id='alterar' name='alterar' onclick=\"altFormaPagamento(${item.id});\">
                        <i class='material-icons right'>edit</i>
                      </button>

                      <button class='btn-floating btn-small waves-effect waves-light red' type='submit' id='deletar' name='deletar'>
                        <i class='material-icons right'>delete</i>
                      </button>
                    </form>
                  </td>
              </tr>
            `);

          });

      }
  };

  xhttp.open("POST", "../form/FormaPagamento.php?listar=1", true);
  xhttp.send();
}
function altFormaPagamento(id){
  $('#modal1').modal('open');
  $('#btn_add').val('alt');
  $('#btn_add').html(`Alterar <i class='material-icons right'>edit</i>`);
  const xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          const retorno = JSON.parse(this.responseText);
            $('#alt_id').val(retorno["id"]);
            $('#add_descricao').val(retorno["descricao"]);
            $('#add_qtd_parcelas').val(retorno["qtd_parcelas"]);
            $('#add_status').val(retorno["status"]);
        }
        M.updateTextFields();
    };
    
    xhttp.open("GET", "../form/carrega_alt_formas_pagamento.php?id=" + id, true);
    xhttp.send();
}
//-------------------------PRODUTOS-----------------------------//
function listaProdutos() {
  const xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          const retorno = JSON.parse(this.responseText);
          $('#corpo').html('');
          $('#corpo').append(`
          <tr>
            <td colspan='5' style='text-align:center;'>Nenhum registro encontrado!</td>
          </tr>
        `)
          let index = 0;
          retorno.forEach(function(item) {
              if(index === 0){
                $('#corpo').html('');
              }
              index = index + 1;

              let status = parseInt(item.status) === 1 ? 'Ativo' : 'Inativo';
           
                $('#corpo').append(`
                <tr>
                    <td style='text-align:left;'>${item.descricao}</td>
                    <td style='text-align:center;'>${item.quantidade.replace('.', ',')}</td>
                    <td style='text-align:center;'>R$ ${item.valor.replace('.', ',')}</td>
                    <td style='text-align:center;'>${status}</td>
                    <td style='text-align:center;'> 
                      <form method="POST" action=\"../form/Produtos.php\" onsubmit="return confirm('Tem certeza de que deseja excluir este registro?');">
                        <input type='hidden' name='id' value='${item.id}'>

                        <button class='btn-floating btn-small waves-effect waves-light blue' type='button' id='alterar' name='alterar' onclick=\"altProduto(${item.id});\">
                          <i class='material-icons right'>edit</i>
                        </button>

                        <button class='btn-floating btn-small waves-effect waves-light red' type='submit' id='deletar' name='deletar'>
                          <i class='material-icons right'>delete</i>
                        </button>
                      </form>
                    </td>
                </tr>
            `);
          });

      }
  };

  xhttp.open("POST", "../form/Produtos.php?listar=1", true);
  xhttp.send();
}
function altProduto(id){
  $('#modal1').modal('open');
  $('#btn_add').val('alt');
  $('#btn_add').html(`Alterar <i class='material-icons right'>edit</i>`);
  const xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          const retorno = JSON.parse(this.responseText);
            $('#alt_id').val(retorno["id"]);
            $('#add_descricao').val(retorno["descricao"]);
            $('#add_quantidade').val(retorno["quantidade"]);
            $('#valor_unitario').val(retorno["valor"]);
            $('#add_status').val(retorno["status"]);
        }
        M.updateTextFields();
    };
    
    xhttp.open("POST", "../form/carrega_alt_produtos.php?id=" + id, true);
    xhttp.send();
}
//--------------------------CLIENTES-----------------------------//
function listaClientes(){
  const xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        $('#corpo').html('');
          $('#corpo').append(`
          <tr>
            <td colspan='7' style='text-align:center;'>Nenhum registro encontrado!</td>
          </tr>
        `)
          let index = 0;
          const retorno = JSON.parse(this.responseText);
          
          retorno.forEach(function(item) {

              if(index === 0){
                $('#corpo').html('');
              }
              index = index + 1;

              let status = parseInt(item.status) === 1 ? 'Ativo' : 'Inativo';

              if(!item){
                $('#corpo').append(`<tr><td colspan='4' style='text-align:center'>Nenhum registro encontrado!</td>`);
              }else{
                $('#corpo').append(`
                <tr>
                    <td style='text-align:left;'>${item.nome}</td>
                    <td style='text-align:left;'>${item.email}</td>
                    <td style='text-align:center;'>${formatarCPF(item.cpf)}</td>
                    <td style='text-align:center;'>${formatarCEP(item.cep)}</td>
                    <td style='text-align:left;'>${item.endereco}</td>
                    <td style='text-align:center;'>${status}</td>
                    <td style='text-align:center;'> 
                      <form method="POST" action=\"../form/Clientes.php\" onsubmit="return confirm('Tem certeza de que deseja excluir este registro?');">
                        <input type='hidden' name='id' value='${item.id}'>

                        <button class='btn-floating btn-small waves-effect waves-light blue' type='button' id='historico' name='Compras do cliente' onclick=\"window.open('vendas_clientes.php?id=${item.id}', '_self');\">
                          <i class='material-icons right'>add_shopping_cart</i>
                        </button>

                        <button class='btn-floating btn-small waves-effect waves-light blue' type='button' id='alterar' name='alterar' onclick=\"altClientes(${item.id});\">
                          <i class='material-icons right'>edit</i>
                        </button>

                        <button class='btn-floating btn-small waves-effect waves-light red' type='submit' id='deletar' name='deletar'>
                          <i class='material-icons right'>delete</i>
                        </button>
                      </form>
                    </td>
                </tr>
            `);
              }
          });

      }
  };

  xhttp.open("POST", "../form/Clientes.php?listar=1", true);
  xhttp.send();
}
function altClientes(id){
  $('#modal1').modal('open');
  $('#btn_add').val('alt');
  $('#btn_add').html(`Alterar <i class='material-icons right'>edit</i>`);
  const xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          const retorno = JSON.parse(this.responseText);
            $('#alt_id').val(retorno["id"]);
            $('#add_nome').val(retorno["nome"]);
            $('#add_cpf').val(retorno["cpf"]);
            $('#add_cep').val(retorno["cep"]);
            $('#add_endereco').val(retorno["endereco"]);
            $('#add_email').val(retorno["email"]);
            $('#add_status').val(retorno["status"]);
        }
        M.updateTextFields();
    };
    
    xhttp.open("POST", "../form/carrega_alt_clientes.php?id=" + id, true);
    xhttp.send();
}
//--------------------------OUTROS-----------------------------//
function addButton(){
  $('#modal1').modal('open');
  $('#modal1').find('input').val('');
  $('#modal1').find('select').val('');
  $('#btn_add').html(`Salvar <i class='material-icons right'>save</i>`);
  $('#btn_add').attr('name', 'add');
  $('#btn_add').val('add');
}
function telafim(tps, msg, retorno) {
  var tipo = tps;
  var msgI = msg;

  if (tipo == 1) {
    msgI = "<i class='large material-icons green-text'>check_circle</i><br> " + msg;
  } else {
    msgI = "<i class='large material-icons red-text'>close</i><br>" + msg;
  }

  var div = document.createElement("div");
  div.id = "sucesso";
  div.innerHTML += "<br><br><br><br><br><br><br>";
  div.style.cssText =
  "display:none; position: fixed; top: 0; left: 0; z-index: 100; width: 100%; height:100%; text-align: center; background:rgba(255,255,255,0.9); border:none;	-webkit-animation-name: animatetopb;-webkit-animation-duration: 0.5s;animation-name: animatetopb;animation-duration: 0.5s;";
  document.body.appendChild(div);
  div.innerHTML +=
  "<div style='font-weight: bold;vertical-align:middle;display:inline-block;height:64px;line-height:20px; font-size:18px;padding-left:5px;'><br>" +
  msgI +
  "</div>";

  $(function(){
      $("#sucesso").show();
      setTimeout(function () {
          $("#sucesso").fadeOut("slow");
          window.open(retorno, '_self');
      }, 700);
  });
}
function filterTable(table, campoFiltro){

  document.getElementById(campoFiltro).addEventListener('input', function() {
    
    var filtro = this.value.toLowerCase();
    var tabela = document.getElementById(table);
    var linhas = tabela.getElementsByTagName('tr');

    for (var i = 1; i < linhas.length; i++) { 
      var celulas = linhas[i].getElementsByTagName('td');
      var mostrar = false;

      for (var j = 0; j < celulas.length; j++) {
        var textoCelula = celulas[j].textContent || celulas[j].innerText;

        if (textoCelula.toLowerCase().indexOf(filtro) > -1) {
          mostrar = true;
          break;
        }
      }

      linhas[i].style.display = mostrar ? '' : 'none';
    }
  });
}
function formatarCPF(cpf) {
  cpf = cpf.replace(/\D/g, '');

  cpf = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');

  return cpf;
}
function formatarCEP(cep) {
  cep = cep.replace(/\D/g, '');

  cep = cep.replace(/(\d{5})(\d{3})/, '$1-$2');

  return cep;
}
function setEndereco(cep){
  $('#add_endereco').val('');
  const xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          const retorno = JSON.parse(this.responseText);
          $('#add_endereco').val(retorno);
      }
      M.updateTextFields();
    };
    
    xhttp.open("POST", "../form/carrega_endereco.php?cep=" + cep, true);
    xhttp.send();
}
//--------------------------VENDAS-----------------------------//
function carregaProdutosVenda(){

  const xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          const retorno = JSON.parse(this.responseText);
          $('#produtos_body').html('');
          $('#produtos_body').append(`
          <tr>
            <td colspan='4' style='text-align:center;'>Nenhum registro encontrado!</td>
          </tr>
        `)
          let index = 0;
          retorno.forEach(function(item) {
              if(index === 0){
                $('#produtos_body').html('');
              }
              index = index + 1;

              if(parseInt(item.status) === 1 && item.quantidade > 0){
                  $('#produtos_body').append(`
                    <tr id='linha_prod_${item.id}'>
                        <td style='text-align:center;'>${item.id}</td>
                        <td style='text-align:center;'>${item.descricao}</td>
                        <td style='text-align:center;'>R$ ${item.valor.replace('.', ',')}</td>
                        <td style='text-align:center;'>${item.quantidade.replace('.', ',')}</td>
                        <td style='text-align:center;'> 
                            <input type='hidden' name='id' value='${item.id}'>
                            <button class='btn-floating btn-small waves-effect waves-light' style="background-color:#0069b4!important;" type='submit' id=${item.id} name=${item.id} onclick='addProduto(${JSON.stringify(item)});'>
                                <i class='material-icons right' style='color:#fff!important;'>add</i>
                            </button>
                        </td>
                    </tr>
                `);
              }
          });
      }
  };

  xhttp.open("POST", "../form/Produtos.php?listar=1", true);
  xhttp.send();
}
function addProduto(data){
  var item = data;

  $(`#linha_prod_${item.id}`).remove();

  var numero = item.quantidade.replace('.', ',');
  var casasDecimais = (numero.toString().split(',')[1] || '');
  var type;
 
  if (casasDecimais == '00') {
      type = '';
  } else {
      type = "step='any'";
  }

  $('#carrinho_body').append(`
    <tr id='linha_car_${item.id}'>
        <td style='text-align:center;'>${item.id}</td>
        <td style='text-align:center;'>${item.descricao}</td>
        <td style='text-align:center;'>R$ ${item.valor.replace('.', ',')}</td>
        <td style='text-align:center;'>
            <input type='number' style='text-align:center;' class='validate' ${type} min='1' max='${item.quantidade}' name='qtd_${item.id}' id='qtd${item.id}' onchange=\"calcularTotal();\">
        </td>
        <td style='text-align:center;'>
          <button class='btn-floating btn-small waves-effect waves-light' style="background-color:#0069b4!important;" type='submit' id=${item.id} name=${item.id} onclick='RemoverProduto(${JSON.stringify(item)});'>
            <i class='material-icons right' style='color:#fff!important;'>delete</i>
          </button>
        </td>
    </tr>  
  `);
  calcularTotal();
}
function RemoverProduto(data){
    var item = data;
   
    $(`#linha_car_${item.id}`).remove();
  
    $('#produtos_body').append(`
    <tr id='linha_prod_${item.id}'>
        <td style='text-align:center;'>${item.id}</td>
        <td style='text-align:center;'>${item.descricao}</td>
        <td style='text-align:center;'>R$ ${item.valor.replace('.', ',')}</td>
        <td style='text-align:center;'>${item.quantidade.replace('.', ',')}</td>
        <td style='text-align:center;'> 
            <input type='hidden' name='id' value='${item.id}'>
            <button class='btn-floating btn-small waves-effect waves-light' style="background-color:#0069b4!important;" type='submit' id=${item.id} name=${item.id} onclick='addProduto(${JSON.stringify(item)});' required>
                <i class='material-icons right' style='color:#fff!important;'>add</i>
            </button>
        </td>
    </tr>
  `);
  calcularTotal();
}
function calcularTotal() {
  var linhas = document.querySelectorAll("tr[id^='linha_car_']");
  var total = 0;

  linhas.forEach(function (linha) {

    var valor = parseFloat(linha.querySelector("td:nth-child(3)").textContent.replace('R$ ', '').replace(',', '.'));
    var quantidadeInput = linha.querySelector("td:nth-child(4) input");
    var quantidade = parseFloat(quantidadeInput.value.replace(',', '.'));

    if (!isNaN(valor) && !isNaN(quantidade)) {
      total += valor * quantidade;
    }
  });

  $('#finalizar').remove();
  if(total > 0 && !document.getElementById('finalizar')){

    $('#carrinho').append(`
      <button class='btn-small' style="background-color:#0069b4 !important; margin-top: 20px;" type='button' name='finalizar' id='finalizar' onclick=\"finalizarCompra();\" required>
        Finalizar compra
      </button> 
    `);

  }

  $('#total').html(`Total: R$ ${total.toFixed(2).replace('.', ',')}`);
}
function finalizarCompra(){
  $('#modal1').modal('open');
  $('#add_clientes').empty();
  $('#add_formas_pagamento').empty();

  $('#add_clientes').append(`
  <option value=''>Selecione um cliente</option>`);
  $('#add_formas_pagamento').append(`
  <option value=''>Selecione uma forma de pagamento</option>`);

  const xhttp1 = new XMLHttpRequest();
  const xhttp2 = new XMLHttpRequest();

  xhttp1.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          const retorno = JSON.parse(this.responseText);
          retorno.forEach(function(item) {
            if(parseInt(item.status) == 1){
              $('#add_clientes').append(`
                <option value=${item.id}>${item.nome}</option>
              `);
            }
          });
        }
        M.updateTextFields();
    };

    xhttp2.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          const retorno = JSON.parse(this.responseText);
          retorno.forEach(function(item) {
            if(parseInt(item.status) == 1 && parseInt(item.qtd_parcelas) > 1){
              $('#add_formas_pagamento').append(`
                <option id=${item.id} name=${item.id} value=${item.qtd_parcelas}>${item.descricao} - Em até ${item.qtd_parcelas}x</option>
              `);
            }else if(parseInt(item.status) == 1){
              $('#add_formas_pagamento').append(`
                <option id=${item.id} name=${item.id} value=${item.qtd_parcelas}>${item.descricao} - Em até ${item.qtd_parcelas}x</option>
              `);
            }
          });
        }
        M.updateTextFields();
    };
    
    xhttp1.open("POST", "../form/Clientes.php?listar=1", true);
    xhttp1.send();

    xhttp2.open("POST", "../form/FormaPagamento.php?listar=1", true);
    xhttp2.send();
}
function campoParcelas(qtd){

  var select = document.getElementById('add_formas_pagamento');
  var selected = select.selectedIndex;
  var option = select.options[selected].id;

  $('#pay').empty();
  $('#pay').css('display', 'none');
  $('#id_forma').val(option);

  if(parseInt(qtd) > 1){
      $('#tipo').val(2);
      $('#pay').css('display', 'block');
      $('#pay').append(`
        <input type='number' min='1' max=${qtd} id='qtd_parcelas' autocomplete='off' class='validate' required>
        <label for='qtd_parcelas' style='font-weight:bold;'>Quantidade de parcelas</label>
      `);
  }else{
    $('#tipo').val(1)
  }

}
function gerarVenda(){
  //------------------- DADOS DA VENDA ------------------//
  var tipo = document.getElementById('tipo').value;
  var cliente = document.getElementById('add_clientes').value;
  var pagamento = document.getElementById('id_forma').value;
  var dados_venda = [];

  if(parseInt(tipo) == 1){
    var qtd_parcelas = document.getElementById('tipo').value;
    var dados_venda = [
      { cliente: cliente },
      { pagamento: pagamento },
      { qtd_parcelas: qtd_parcelas }
    ];
  }else{
    var qtd_parcelas = document.getElementById('qtd_parcelas').value;
    var dados_venda = [
      { cliente: cliente },
      { pagamento: pagamento },
      { qtd_parcelas: qtd_parcelas }
    ];
  }
//------------------- PRODUTOS DA VENDA ------------------//
  var dados_produtos = [];
  var i = 0;
  var linhas = document.querySelectorAll("tr[id^='linha_car_']");

  try {
    linhas.forEach(function (linha) {
      var id = linha.querySelector("td:nth-child(1)").innerHTML;
      var quantidadeInput = linha.querySelector("td:nth-child(4) input");
      
      if (quantidadeInput && quantidadeInput.value.trim() !== "") {
        var quantidade = parseFloat(quantidadeInput.value.replace(',', '.'));
  
        var produto = {
          id: id,
          quantidade: quantidade
        }
  
        dados_produtos.push(produto);
      } else {
        throw new Error("Preencha todas as quantidades para enviar!");
      }
    });
  } catch (error) {
    alert(error.message);
    return;
  }
//------------------- INFORMAÇÃO COMPLETA -------------------//
  var dados = {
    venda: dados_venda,
    produtos: dados_produtos
  };
//------------------- MANDAR REQUISIÇÃO HTTP -------------------//
  var dadosJSON = JSON.stringify(dados);
  var xhr = new XMLHttpRequest();

  xhr.open('POST', '../form/Vendas.php?gerar=1', true);
  xhr.setRequestHeader('Content-Type', 'application/json');

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      const retorno = parseInt(this.responseText);
      if(retorno == 1){
        var url = '../views/vendas.php?sucesso=Venda realizada com sucesso!'
      }else{
        var url = '../views/vendas.php?erro=Ocorreu um erro ao realizar a venda!'
      }
      window.location.href = url;
    }
  };  

  xhr.send(dadosJSON);
}

function listaVendas(id) {
  const xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      const retorno = JSON.parse(this.responseText);
      $('#corpo').html('');

      if (retorno.length === 0) {
        $('#corpo').append(`
          <tr>
            <td colspan='4' style='text-align:center;'>Nenhum registro encontrado!</td>
          </tr>
        `);
      } else {
        retorno.forEach(function(item) {
          $('#corpo').append(`
            <tr>
              <td style='text-align:left;'>${item.cliente}</td>
              <td style='text-align:center;'>${item.forma_pagamento}</td>
              <td style='text-align:center;'>${item.qtd_parcelas}x</td>
              <td style='text-align:center;'>R$ ${parseFloat(item.valor).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
            </tr>
          `);
        });
      }
    }
  };

  xhttp.open("POST", "../form/Clientes.php?listar_vendas=1&id_cliente=" + id, true);
  xhttp.send();
}
