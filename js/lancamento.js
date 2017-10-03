

/**
 * Created by carlos.bruno on 29/09/2017.
 */


$(document).ready(function () {
   $('.mensagem').fadeOut();
   $('.progress').fadeOut();
   $('.msgAvisoModal').fadeOut();
});


$('.btn-novo').on('click', function () {
    carregarListaCliente();
    carregarListaProduto();
    $('.modal-registro').modal('show');

});

function carregarListaCliente() {
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
                $('<option />').val( 0 ).text( 'Selecione' )
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
                $('<option />').val( 0 ).text( 'Selecione' )
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
    adicionarItemTable();
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
        "</tr>";
    $('#tb-itens').append( linha );

    calcularTotal();

}

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
    $('.vl-total').text( formataDinheiro( valor ) );
}