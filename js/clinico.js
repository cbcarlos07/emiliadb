/**
 * Created by carlos.bruno on 21/08/2017.
 */

$(document).ready(function () {
    var tbody = $('.tbody');
    tbody.find('tr').remove();
    comboBoxEspecialidade();
    comboBoxEspecialid();
    $('.progress').fadeOut();
    $('.mensagem').fadeOut();
    $('.msgAvisoModal').fadeOut();
    getAtendimentos();
})

function comboBoxEspecialidade(  ) {
    $('#especialidade').find('option').remove();
    $.ajax({
        url   : 'function/especialidade.php',
        type  : 'post',
        dataType : 'json',
        data : {
            acao : 'L'
        },
        success : function (data) {

            $.each( data.objetos, function (i, j) {
                $("#especialidade").append($("<option />").val(j.id).text(j.name));

            } );

            //getAtendimentos();


        }
    });
}


function comboBoxEspecialid(  ) {
    $('#especcombo').find('option').remove();
    $.ajax({
        url   : 'function/especialidade.php',
        type  : 'post',
        dataType : 'json',
        data : {
            acao : 'L'
        },
        success : function (data) {

            $.each( data.objetos, function (i, j) {
                $("#especcombo").append($("<option />").val(j.id).text(j.name));

            } );

            getAtendimentos();


        }
    });
}

 $('#especialidade').on('change', function () {
   getAtendimentos();
});

 function getAtendimentos() {
     var espec = $('#especialidade').val();
     console.log("Especialidade: "+espec);
     var tbody = $('.tbody');
     tbody.find('tr').remove();
     $.ajax( {
         url   : 'function/atendimento.php',
         type  : 'post',
         dataType : 'json',
         data : {
             acao : 'L',
             especialidade : espec
         }, success : function (data) {

             $.each( data.objetos, function (i, j) {
                 tbody.append(
                     '<tr>'+
                         '<td>'+ j.id +'</td>'+
                         '<td>'+ j.nome +'</td>'+
                         '<td>'+ j.especialidade +'</td>'+
                         '<td> <a href="#alterar" class="btn btn-warning btn-editar" data-id="'+ j.id +'" data-nome="'+ j.nome +'"  data-paciente="'+data.paciente+'" > <i class="fa fa-pencil-square-o"></i>Alterar </a></td>'+
                         '<td> <a href="#excluir" class="btn btn-danger btn-excluir" data-id="'+ j.id +'" data-nome="'+ j.nome +'"> <i class="fa fa-times"> Excluir </a></td>'+
                     '</tr>'
                 );
             } );

             $('.btn-editar').on('click', function () {
                 var id = $(this).data('id');
                 var paciente = $(this).data('paciente');
                 var nome = $(this).data('nome');


                 $('span.nm-pac').text(nome);
                 $('.modal-alt').modal('show');
                 $('.btn-yes').on('click', function () {
                     var especialid = $('#especcombo').val();
                     console.log("Especialidade nova: "+especialid);
                     $.ajax({
                         url : 'function/atendimento.php',
                         type : 'post',
                         dataType : 'json',
                         data : {
                             id : id,
                             paciente : paciente,
                             especialidade : especialid,
                             acao : 'A'

                         },
                         success : function (data) {
                             if( data.sucesso === 1 ){
                                 msgSucessoModal();
                             }
                         }
                     });
                 });

             });

             $('.btn-excluir').on('click', function () {
                 var id = $(this).data('id');
                 var nome = $(this).data('nome');
                 $('span.user-nome').text( nome );
                 $('.modal-question').modal('show');
                  $('.btn-sim').on('click', function () {
                      $.ajax({
                          url  : 'function/atendimento.php',
                          type : 'post',
                          dataType : 'json',
                          data : {
                              acao : 'E',
                              id   : id
                          },
                          success : function (data) {
                              if( data.success === 1 ){
                                  msgSucessoModal();
                              }

                          }
                      })
                  })

             });



         }
     } );
 }


function msgSucessoModal() {
    var mensagem = $('.msgAvisoModal');
    mensagem.empty().html("<p class='alert alert-success'><strong>Parab&eacute;ns</strong> Opera&ccedil;&atilde;o realizada com sucesso! </p>").fadeIn();
    setTimeout(function () {
        location.href = "atendimentos.php";
    },3000);
}

$('#especcombo').on('change', function () {
    console.log("Espec "+$(this).val());
});

 $('.btn-print').on('click', function () {
     console.log("Btn print");
     var combo = $('#especialidade :selected');
     var espec = combo.val();
     var especialidade = combo.text();
     var form = $('<form action="services/pdf.php" method="post">' +
                     '<input type="hidden" value="'+ espec +'" name="id">'+
                     '<input type="hidden" value="'+ especialidade +'" name="nome">'+
                  '</form>');
     $('body').append(form);
     form.submit();
 });