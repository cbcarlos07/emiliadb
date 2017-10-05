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
            var pessoa;
            var empresa;
            var cracha;

            $.each( data, function (i, j) {

                pessoa  = j.pessoa;
                empresa = j.empresa;
                cracha  = j.cracha;
                itens.append(
                    "<tr>" +
                        "<td><input type='checkbox' id='check' value='"+j.codigo+"'  class='chcktbl'></td>"+
                        "<td>"+ j.codigo +"</td>"+
                        "<td>"+ j.produto +"</td>"+
                        "<td>"+ j.qtde +"</td>"+
                        "<td>"+ formataDinheiro( parseFloat( j.valor ) ) +"</td>"+
                        "<td>"+ j.data +"</td>"+
                        "<td><a class='btn btn-success btn-pay-one' data-valor='"+ formataDinheiro( parseFloat( j.valor ) ) +"' data-id='"+ j.codigo +"'>Registar Pagamento</a></td>"+
                    "</tr>"
                );
            } );


            $('.btn-pay-one').on('click', function () {
                var valor = $(this).data('valor');
                var id = $(this).data('id');

                $('span.vl-total').html( valor );
                var divValor = $('#valorpago');
                divValor.val( "R$ 0,00" );
                $('#cdregistro').val( id )
                calcularTroco();
                $('.modal-registro').modal('show');
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
        $('.btn-novo').removeAttr("disabled");
    }
}

function formataDinheiro( n ) {
    return "R$ " + n.toFixed(2).replace('.', ',').replace(/(\d)(?=(\d{3})+\,)/g, "$1.");
}