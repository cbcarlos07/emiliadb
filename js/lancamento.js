

/**
 * Created by carlos.bruno on 29/09/2017.
 */


$(document).ready(function () {
   $('.mensagem').fadeOut();
   $('.progress').fadeOut();
   $('.msgAvisoModal').fadeOut();
   preencherTabela();
});


$('.btn-novo').on('click', function () {
    carregarListaCliente();
    carregarListaProduto();
    $('.modal-registro').modal('show');

});

function carregarListaCliente(  ) {
    var combo = $('#cliente');
    combo.find('option').remove();
    $.ajax({
        url  : 'function/pessoa.php',
        type : 'post',
        dataType : 'json',
        data : {
            acao : 'L'
        },
        success: function (data) {
            combo.append(
                $('<option />').val( 0 )
            );
            $.each( data.objetos, function (i, j) {

               combo.append(
                    $('<option />').val( j.id ).text( j.nome )
                );
            } );

            combo.trigger("chosen:updated");
        }
     });

}



function carregarListaProduto() {
    var combo = $('#produto');
    combo.find('option').remove();
    $.ajax({
        url  : 'function/item.php',
        type : 'post',
        dataType : 'json',
        data : {
            acao : 'L'
        },
        success: function (data) {
            combo.append(
                $('<option />').val( 0 )
            );
            $.each( data.objetos, function (i, j) {

                combo.append(
                    $('<option />').val( j.id ).text( j.descricao )
                );
            } );

            combo.trigger("chosen:updated");
        }
    });

}

$('#produto').on('change', function () {
    var id = $(this).val();
    if (id > 0 ){
        getValor( id );
    }else{
        $('#valor').val("");
        $('#subtotal').val("");


    }

});

$('#qtde').on('input', function () {
    calcularSubTotal();
});

var valor;
function getValor( id ) {
    $.ajax({
        url : 'function/item.php',
        type: 'post',
        dataType: 'json',
        data: {
            acao : 'G',
            id   :  id
        },
        success : function (data) {

            valor = data.valor;
            $('#valor').val( formataDinheiro( parseFloat( data.valor ) ) );
            calcularSubTotal();

        }
    });
}


function formataDinheiro( n ) {
    return "R$ " + n.toFixed(2).replace('.', ',').replace(/(\d)(?=(\d{3})+\,)/g, "$1.");
}

function calcularSubTotal() {
    var qtde = $('#qtde').val();

    var subTotal = qtde * parseFloat( valor );

    $('#subtotal').val( formataDinheiro( subTotal ) )
}

$('.btn-adicionar').on('click', function () {
  //  console.log("Adicionar");
    if( ( $('#cliente').val() > 0 ) &&  ( $('#produto').val() > 0 ) ) {
        adicionarItemTable();
        $('#cliente.chosen-container-single').removeClass('required');
    }else{

         if( $('#cliente').val() == 0 ){
             console.log("Falta selecionar um cliente");
             $('#cliente_chosen').addClass('required');
         }

        if( $('#produto').val() == 0 ){
            $('#produto_chosen').addClass('required');
        }
    }

});

function adicionarItemTable() {
    var produto = $('#produto :selected');
    var item = produto.val();
    var qtde = $('#qtde').val();
    var desc = produto.text();
    var valor = $('#subtotal').val();
  /*  console.log("Item: "+item);
    console.log("Qtde: "+qtde);
    console.log("Descricao: "+desc);
    console.log("Valor: "+valor);*/

    var linha = "" +
        "<tr>" +
            "<td>"+ item +"</td>"+
            "<td>"+ desc +"</td>"+
            "<td>"+ qtde +"</td>"+
            "<td>"+ valor +"</td>"+
        "  <td><a href='#div' class='btn btn-danger btn-remove btn-xs'>remover</a></td>"+
        "</tr>";
    $('#tb-itens').append( linha );

    calcularTotal();

}

$("#tb-itens").on("click", ".btn-remove", function(e){
    $(this).closest('tr').remove();
});


function calcularTotal() {
    var valor = 0;
    $('.tb-produtos').find('tr').each(function(indice){
        var tableData = $(this).children("td").map(function()         {
            return $(this).text();
        }).get();
        //console.log("Clique: "+$.trim(tableData[0]));
        var dado = $.trim(tableData[3]) ;
      //  console.log("Dado: "+dado);
        if( dado != "" )
           valor +=  parseFloat( dado.replace("R$ ","").replace(",",".") );
    });

  //  console.log( "Total: "+valor );
    $('.total').text( formataDinheiro( valor ) );
}

$('.btn-sim').on('click', function () {
    salvarItens();
});



$('#valorpago').on('input', function () {
    calcularTroco();
});

function calcularTroco() {
    console.log("Calcular troco");
    var idTroco = $('input[id="troco"]');
    var strTotal = $('span.vl-total').text();
    var fTotal = parseFloat( strTotal.replace("R$ ","").replace(",",".") );

    var strValor = $('#valorpago').val(  );
    var fValor   = parseFloat( strValor.replace( "R$ ","" ).replace( ",","." ) )

    var vTroco = fValor - fTotal;

    idTroco.val(  formataDinheiro( vTroco )  );

    if( vTroco < 0){
        idTroco.css( "color", "red" );
    }else{
        idTroco.css( "color", "green" );
    }


}

function salvarItens() {
   var pessoa = $('#cliente').val();
   var tabela  = $('.tb-produtos').tableToJSON();
   var itens   = JSON.stringify( tabela );
   var pago    = $('#pago');
   var snpago = "N";
   if( pago.is(":checked") ){
       snpago = "S";
   }

   $.ajax({
       url  : 'function/registro.php',
       type : 'post',
       dataType: 'json',
       beforeSend : aguardandoModal,
       data : {
           acao : 'R',
           pessoa : pessoa,
           pago   : snpago,
           itens  : itens
       },
       success : function (data) {
           if( data.retorno > 0 ){
                msgSucessoModal();
           }else{
               erroSendModal();
           }
       }
   })

}




function aguardando() {
    $('.progress').fadeIn();
}

function erroSend() {
    var mensagem = $('.mensagem');
    mensagem.empty().html("<p class='alert alert-danger'><strong>Ops</strong> Ocorreu um erro ao processar sua requisi&ccedil;&atilde;o </p>").fadeIn();
    setTimeout(function () {
        mensagem.fadeOut('slow');
    }, 3000)

}

function aguardandoModal() {
    var mensagem = $('.progressModal');
    mensagem.empty().html("<p class='alert alert-danger'><strong>Ops</strong> Ocorreu um erro ao processar sua requisi&ccedil;&atilde;o </p>").fadeIn();
    setTimeout(function () {
        mensagem.fadeOut('slow');
    }, 3000)

}

function erroSendModal() {
    var mensagem = $('.msgAvisoModal');
    mensagem.empty().html("<p class='alert alert-danger'><strong>Ops</strong> Ocorreu um erro ao processar sua requisi&ccedil;&atilde;o </p>").fadeIn();
    setTimeout(function () {
        mensagem.fadeOut('slow');
    }, 3000)

}

function msgSucesso() {
    var mensagem = $('.mensagem');
    mensagem.empty().html("<p class='alert alert-success'><strong>Parab&eacute;ns</strong> Opera&ccedil;&atilde;o realizada com sucesso! </p>").fadeIn();
    setTimeout(function () {
        mensagem.fadeOut();
        location.href = "pessoa.php";
    },3000);
}


function msgSucessoModal() {
    var mensagem = $('.msgAvisoModal');
    mensagem.empty().html("<p class='alert alert-success'><strong>Parab&eacute;ns</strong> Opera&ccedil;&atilde;o realizada com sucesso! </p>").fadeIn();
    setTimeout(function () {
        location.href = "lancamento.php";
        preencherTabela();
    },3000);
}

function preencherTabela() {
     var tbody = $('.tbody');
     tbody.find('tr').remove();
    $.ajax({
        url: 'function/registro.php',
        type: 'post',
        dataType: 'json',
        data: {
            acao: 'L',
            pessoa: '%',
            cracha: '%'
        },
        success: function (data) {
            var total = 0;
            $.each(data, function (item, chave) {
                total += parseFloat(chave.valor);
                // console.log("Codigo: "+chave.codigo);
                tbody.append(
                    "<tr>" +
                    "<td>" + chave.cracha + "</td>" +
                    "<td>" + chave.pessoa + "</td>" +
                    "<td>" + chave.empresa + "</td>" +
                    "<td> <a href='#pg' data-id='" + chave.cracha + "' class='lnk-pgto'>" + formataDinheiro(parseFloat(chave.valor)) + "</a> </td>" +
                    "<td> " +
                    "<a class='btn btn-primary btn-detail' data-id='" + chave.codigo + "'> Detalhes </a>" +
                    "<a class='btn btn-success btn-pay' data-id='" + chave.codigo + "'> Registrar Pagamento </a> " +

                    "</td>" +

                    "</tr>"
                );
            });

            $('span.total').text(formataDinheiro(total));
            var btn_print = $('.btn-print');
            if( total > 0 ){
                btn_print.attr("disabled", false);
            }else{
                btn_print.attr("disabled", true);
            }


            $('.btn-pay').on('click', function () {
                var id = $(this).data('id');
                console.log("Total: "+formataDinheiro( total ));
                $('span.vl-total').text( formataDinheiro( total ) );
                calcularTotal();
                $('.modal-pay').modal('show');
                //calcularTroco();
                $('.btn-yes').on( 'click', function () {
                        $.ajax({
                            url : 'function/registro.php',
                            type: 'post',
                            dataType: 'json',
                            beforeSend : aguardandoModal(),
                            data: {
                                acao : 'V',
                                pessoa : id
                            },
                            success : function (data) {
                                if( data.retorno > 0 ){
                                    msgSucessoModal();
                                }else{
                                    erroSendModal();
                                }
                            }
                        })
                } );

            });

            $('.btn-detail').on('click', function () {
                var id = $(this).data('id');
                //  alert("Codigo: "+id);
                var form = $('<form action="registros.php" method="post">' +
                    '<input type="hidden" name="id" value="' + id + '">' +
                    '</form>');
                $('body').append(form);
                form.submit();
            });


        }
    });
}


$('#nome').on('input', function () {
    $('#cracha').val("");
    carregarTabela( $(this).val(), '' );
});

$('#cracha').on('input', function () {
    $('#nome').val("");
    carregarTabela( '', $(this).val() );
});

function carregarTabela( pessoa, cracha ) {
    var tbody = $('.tbody');
    tbody.find('tr').remove();
    $.ajax({
        url: 'function/registro.php',
        type: 'post',
        dataType: 'json',
        data: {
            acao: 'L',
            pessoa: pessoa,
            cracha: cracha
        },
        success: function (data) {
            var total = 0;
            $.each(data, function (item, chave) {
                total += parseFloat(chave.valor);
                // console.log("Codigo: "+chave.codigo);
                tbody.append(
                    "<tr>" +
                    "<td>" + chave.cracha + "</td>" +
                    "<td>" + chave.pessoa + "</td>" +
                    "<td>" + chave.empresa + "</td>" +
                    "<td> <a href='#pg' data-id='" + chave.cracha + "' class='lnk-pgto'>" + formataDinheiro(parseFloat(chave.valor)) + "</a> </td>" +
                    "<td> " +
                    "<a class='btn btn-primary btn-detail' data-id='" + chave.codigo + "'> Detalhes </a>" +
                    "<a class='btn btn-success btn-pay' data-id='" + chave.codigo + "'> Registrar Pagamento </a> " +

                    "</td>" +

                    "</tr>"
                );
            });

            $('span.total').text(formataDinheiro(total));
            var btn_print = $('.btn-print');
            if( total > 0 ){
                btn_print.attr("disabled", false);
            }else{
                btn_print.attr("disabled", true);
            }


            $('.btn-pay').on('click', function () {
                var id = $(this).data('id');
                console.log("Total: "+formataDinheiro( total ));
                $('span.vl-total').text( formataDinheiro( total ) );
                calcularTotal();
                $('.modal-pay').modal('show');
                //calcularTroco();
                $('.btn-yes').on( 'click', function () {
                    $.ajax({
                        url : 'function/registro.php',
                        type: 'post',
                        dataType: 'json',
                        beforeSend : aguardandoModal(),
                        data: {
                            acao : 'V',
                            pessoa : id
                        },
                        success : function (data) {
                            if( data.retorno > 0 ){
                                msgSucessoModal();
                            }else{
                                erroSendModal();
                            }
                        }
                    })
                } );

            });

            $('.btn-detail').on('click', function () {
                var id = $(this).data('id');
                //  alert("Codigo: "+id);
                var form = $('<form action="registros.php" method="post">' +
                    '<input type="hidden" name="id" value="' + id + '">' +
                    '</form>');
                $('body').append(form);
                form.submit();
            });


        }
    });
}


$('.btn-print').on('click', function () {
    var total = $('span.total').text();
    var form = $('<form action="services/pdf.php" method="post" target="_blank">' +
                    '<input type="hidden" name="valor" value="'+total+'">'+
                '</form>');
    $('body').append( form );
    form.submit();
});