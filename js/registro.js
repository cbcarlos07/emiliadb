/**
 * Created by carlos.bruno on 05/10/2017.
 */

$(document).ready(function () {
   $('.mensagem').fadeOut();
   $('.progress').fadeOut();
   $('.msgAvisoModal').fadeOut();
   carregarTabela();
   /* $("#valorpago").maskMoney({
        prefix: "R$ ",
        decimal: ",",
        thousands: "."
    });
*/

});

$('#valorpago').on("input", function () {
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

function carregarTabela() {
    var id = $('#id').val();
    var itens = $('.tbody');
    itens.find('tr').remove();
    $.ajax({
        url : 'function/registro.php',
        type : 'post',
        dataType : 'json',
        data :{
            acao : 'I',
            pessoa : id
        },
        success : function (data) {
            var pessoa   = "";
            var empresa  = "";
            var cracha   = "";
            var total    = 0;

            $.each( data, function (i, j) {

                pessoa  = j.pessoa;
                empresa = j.empresa;
                cracha  = j.cracha;
                total   += parseFloat( j.valor );
                itens.append(
                    "<tr>" +
                        "<td><input type='checkbox' id='check' data-valor='"+ j.valor +"' value='"+j.codigo+"'  class='chcktbl'></td>"+
                        "<td>"+ j.codigo +"</td>"+
                        "<td>"+ j.produto +"</td>"+
                        "<td>"+ j.qtde +"</td>"+
                        "<td>"+ formataDinheiro( parseFloat( j.valor ) ) +"</td>"+
                        "<td>"+ j.data +"</td>"+
                        "<td><a class='btn btn-success btn-pay-one' data-valor='"+ formataDinheiro( parseFloat( j.valor ) ) +"' data-id='"+ j.codigo +"'>Registar Pagamento</a></td>"+
                    "</tr>"
                );
            } );

            $('span.nome').text( pessoa );
            $('span.cracha').text( cracha );
            $('span.empresa').text( empresa );
            $('span.total').text( formataDinheiro( total ) );


            $('.btn-pay-one').on('click', function () {
                var valor = $(this).data('valor');
                var id = $(this).data('id');
                console.log("Id do registro: "+id);
                $('span.vl-total').html( valor );
                var divValor = $('#valorpago');
                //divValor.val( "R$ 0,00" );
                $('#cdregistro').val( id );
                calcularTroco();
                $('.modal-registro').modal('show');

                $('.btn-sim').on('click', function () {
                    console.log("Registrar pagamento");
                    registrarPagamento( id );
                });
            });


        }
        
    })
}

$(document).on('change', '#checkHead', function (e) {
   // console.log("Click");
    var table= $(e.target).closest('table');
    $('td input:checkbox',table).prop('checked',this.checked);
    totalChecado();
});

$(document).on('change', '.chcktbl', function (e) {

    totalChecado();
});
var numberOfChecked = 0;
function totalChecado() {

    // numberOfChecked = $('input:checkbox:checked').length;
     numberOfChecked = $('input[class="chcktbl"]:checked').length;
    console.log("Numero checado: "+numberOfChecked);
    if( numberOfChecked > 1 ){
        $('.btn-multiple').removeAttr("disabled");
    }else{
        $('.btn-multiple').attr("disabled",true);
    }
}

function formataDinheiro( n ) {
    return "R$ " + n.toFixed(2).replace('.', ',').replace(/(\d)(?=(\d{3})+\,)/g, "$1.");
}


$('.btn-multiple').on('click', function () {
    var valor = 0;
    var id = [];
    $('.chcktbl:checked').each(function () {

     //   console.log( "Codigo: "+$(this).val()+" Valor: "+$(this).data('valor') );

        valor += parseFloat( $(this).data('valor') );

        id.push( $(this).val() );




    });

    $('span.vl-total').html( formataDinheiro( valor ) );
    var divValor = $('#valorpago');
    //divValor.val( "R$ 0,00" );

    calcularTroco();
    $('.modal-registro').modal('show');

    $('.btn-sim').on('click', function () {
        $.each( id, function (i, j) {
            console.log("Registrar pagamento: "+i);

            registrarPagamento( id[i] );
        } );

    });
});


function registrarPagamento( id ){
     console.log("funcao registrarPagamento");
    $.ajax({
        url  : 'function/registro.php',
        type : 'post',
        dataType : 'json',
        beforeSend: aguardandoModal,
        data : {
            pago : 'S',
            registro : id,
            acao     : 'P'
        },
        success : function ( data ) {
            console.log("Retorno: "+data.retorno);
            if( data.retorno == 1 ){
                msgSucessoModal();
            }else{
                erroSendModal();
            }
        },
        error : function (data) {
            console.log(data);
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
        location.reload();
      //  preencherTabela();
    },3000);
}