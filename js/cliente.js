/**
 * Created by carlos on 20/08/17.
 */

$(document).ready(function () {
    getListObj();
    comboBoxEmpresa( 0 );
    $('.progress').fadeOut();
    $('.mensagem').fadeOut();
    $('.msgAvisoModal').fadeOut();
    getObj( $('#id').val() );
    $('#cep').mask('00.000-000');


});

$('.btn-refresh').on('click', function () {
    comboBoxEmpresa( 0 );
});

function comboBoxEmpresa( id ) {
    $('#empresa').find('option').remove();
    $.ajax({
        url   : 'function/empresa.php',
        type  : 'post',
        dataType : 'json',
        data : {
            acao : 'L'
        },
        success : function (data) {

            $.each( data.objetos, function (i, j) {
                $("#empresa").append($("<option />").val(j.id).text(j.name));
            } );
            $("#empresa").trigger("chosen:updated");
            if( id > 0 )
                $("#empresa").val( id ).trigger("chosen:updated");


        }
    });
}

function getObj( id ) {
    if( id > 0 ){
        var tbody = $('.tbodycad');
        tbody.find('tr').remove();
        $.ajax({
            url  : 'function/pessoa.php',
            type : 'post',
            dataType : 'json',
            data : {
                acao : 'G',
                id   : id
            },
            success : function (data) {
                $('#nome').val( data.nome );
                $('#cracha').val( data.cracha );
                comboBoxEmpresa( data.empresa );
                $('#cep').val( data.cep );
                $('#nrcasa').val( data.casa );
                $('#complemento').val( data.complemento );

                $.each(data.telefone, function (i, j) {
                        tbody.append(
                            "<tr>"+
                                "<td>" + j.telefone + "</td>"+
                                "<td>" + j.obs + "</td>"+
                                "<td>" + j.tipo + "</td>"+
                                "<td>" + j.dstipo + "</td>"+
                            "</tr>"
                        );
                });


                buscarCEP(  );
                calcularIdade();

            }
        })

    }
}




$('.btn-salvar').on('click',function () {
    if( validarcampos() ){
        var acao   = $('#acao').val();
        var id     = $('#id').val();
        var nome   = $('#nome').val();
        var cracha = $('#cracha').val();
        var cep    = $('#cep').val();
        var casa   = $('#nrcasa').val();
        var complemento = $('#complemento').val();
        var empresa = $('#empresa').val();
        var fones = $('.table-fone').tableToJSON();
        var telefone = JSON.stringify( fones );

        $.ajax({
            url   : 'function/pessoa.php',
            type  : 'post',
            dataType : 'json',
            beforeSend : aguardando,
            data : {

                acao        : acao,
                id          : id,
                nome        : nome,
                cracha      : cracha,
                cep       : cep,
                casa      : casa,
                complemento : complemento,
                empresa     : empresa,
                telefone    : telefone
            },
            success : function (data) {
                $('.progress').fadeOut();
                if( data.sucesso === 1){
                    msgSucesso();

                }else{
                    erroSend();
                }
            }
        });

    }
    return false;
})

$('.btn-ok').on('click', function () {
   var cdespec = $('#especialidade').val();
   var paciente = $('#cdpac').val();
  // alert("Paciente: "+paciente);
   var acao     = $('#acaoModal').val();
   console.log("Acao: "+acao);
   $.ajax({
       url : 'function/atendimento.php',
       dataType : 'json',
       type : 'post',
       data : {
            paciente : paciente,
            especialidade : cdespec,
            acao : acao
       },
       success : function (data) {
           if( data.sucesso === 1 ){

                $('.progressModal').fadeOut();
                msgSucessoModal();

           }else{
               $('.progressModal').fadeOut();
               erroSendModal();
           }
       }
   });
});


$('.btn-cancelar').on('click', function(){
   $('.modal-question').modal('show');
   $('.btn-sim').on('click', function () {
       location.href = "paciente.php";
   });
});



function getListObj() {
    $('.tbody').find( 'tr' ).remove();
    $.ajax({
        url  : 'function/paciente.php',
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
                        "<td>"+ j.name +"</td>"+
                        "<td>" +
                            "<a href='#editar' class='btn btn-warning btn-editar' title='Editar' data-id='"+ j.id +"'><i class='fa fa-pencil-square-o'></i> Editar </a> &nbsp;" +
                            "<a href='#excluir' class='btn btn-danger btn-excluir' title='Excluir' data-id='"+ j.id +"' data-nome='"+ j.name +"'><i class='fa fa-times'></i> Excluir</a>" +
                        "</td>"+
                    "</tr>"


                );
            } );

            $('.btn-editar').on('click', function () {
              //  console.log("Editar");
                var id = $(this).data('id');
                var form = $('<form method="post" action="pacientealt.php">'+
                    '<input type="hidden" name="id" value="'+ id +'" />'+
                    '</form>');
                $('body').append(form);
                form.submit();
            });

            $('.btn-excluir').on('click', function () {
             //   console.log("Editar");
                var id = $(this).data('id');
                var nome = $(this).data('nome');
                $('span.user-nome').text(nome);
                $('.modal-question').modal('show');
                $('.btn-sim').on('click', function () {
                    $.ajax({
                        url  : 'function/paciente.php',
                        type : 'post',
                        dataType: 'json',
                        befereSend : aguardandoModal,
                        data : {
                            acao : 'E',
                            id   : id
                        },
                        success : function (data) {

                            $('.progress').fadeOut();
                            if( data.success === 1 ){
                                msgSucessoModal();
                            }else{
                                erroSendModal();
                            }
                        }
                    });
                });


            });

        }
    });

}

function validarcampos() {

    var descricao = $('#descricao').val();

    if( descricao != "" ){
        colorirCampo( "descricao", "" );
        return true;
    }else{
        if( descricao == "" ){
            colorirCampo( "descricao", "red" );
        }

        return false;
    }



}


function colorirCampo( id, cor ) {

    $('input[id="'+ id +'"]').css( "border-color", cor );

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
        location.href = "paciente.php";
    },3000);
}


$('.btn-add').on('click',function () {
    // alert("Add");
    var corpo = $('.tbodycad');
    var telefone    = $('#telefone').val();
    var observacao  = $('#observacao').val();
    var tipo        = $('#tipo').val();
    var dsTipo      = $('#tipo option:selected').text();
    var fone = "";
/*    if(telefone.length <= 11){
        if( telefone.length === 11 ){
          fone = "("+telefone.substr(0,2)+")"+telefone.substr(2,5)+"-"+telefone.substr(7,4);
        }else if( telefone.length === 9 ){

        }
    }else{
        fone = "("+telefone.substr(0,2)+")"+telefone.substr(2,4)+"-"+telefone.substr(6,4);
    }*/

    var content = "<tr>"+
        "  <td>"+telefone+"</td>"+
        "  <td>"+observacao+"</td>"+
        "  <td>"+tipo+"</td>"+
        "  <td>"+dsTipo+"</td>"+
        "  <td><a href='#div' class='btn btn-danger btn-remove btn-xs'>remover</a></td>"+
        "</tr>";
    $(corpo).append(content);
    $('#telefone').val("");
    $('#observacao').val("");
    $('#tipo').val(0);
    //document.getElementById('tipo').selectedIndex = "0";

});

$(".tbodycad").on("click", ".btn-remove", function(e){
    $(this).closest('tr').remove();
});

$('#cep').on("focusout", function () {
    buscarCEP();
    $('#nrcasa').focus();
})

function buscarCEP() {
    //alert("CE OUt");
    var text_cep = $('#cep').val();
    var cep = text_cep.replace(".","").replace("-","");
    //alert('Buscar CEp');
    //Preenche os campos com "..." enquanto consulta webservice.
    $("#logradouro").val("...");
    $("#bairro").val("...");

    //Consulta o webservice viacep.com.br/
    $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

        if (!("erro" in dados)) {
            //Atualiza os campos com os valores da consulta.
            $("#logradouro").val(dados.logradouro);
            $("#bairro").val(dados.bairro);
        } //end if.
        else {
            //CEP pesquisado não foi encontrado.
            //limpa_formulário_cep();
            errosend("CEP não encontrado.");
        }
    });
}
