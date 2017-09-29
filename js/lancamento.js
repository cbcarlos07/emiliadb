

/**
 * Created by carlos.bruno on 29/09/2017.
 */


$(document).ready(function () {
   $('.mensagem').fadeOut();
   $('.progress').fadeOut();
   $('.msgAvisoModal').fadeOut();
});


$('.btn-novo').on('click', function () {
    $('.modal-registro').modal('show')
});

function carregarListaClinete() {
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
            $.each( data.objetos, function (i, j) {



                $('.tbody').append(
                    "<tr>"+
                    "<td>"+ j.id +"</td>"+
                    "<td>"+ j.nome +"</td>"+
                    "<td>"+ j.empresa +"</td>"+
                    "<td>" +
                    "<a href='#editar' class='btn btn-warning btn-editar' title='Editar' data-id='"+ j.id +"'><i class='fa fa-pencil-square-o'></i> Editar </a> &nbsp;" +
                    "<a href='#excluir' class='btn btn-danger btn-excluir' title='Excluir' data-id='"+ j.id +"' data-nome='"+ j.nome +"'><i class='fa fa-times'></i> Excluir</a>" +
                    "</td>"+
                    "</tr>"


                );
            } );
        }
     });

}