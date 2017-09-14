/**
 * Created by carlos on 20/08/17.
 */

$(document).ready(function () {
    getUsuarios();
    $('.progress').fadeOut();
    $('.mensagem').fadeOut();
    getUser( $('#id').val() );
    comboNivel();
});

function getUser( id ) {
    if( id > 0 ){

        $.ajax({
            url  : 'function/usuario.php',
            type : 'post',
            dataType : 'json',
            data : {
                acao : 'G',
                id   : id
            },
            success : function (data) {
                $('#nome').val( data.nome );
                $('#login').val( data.login );
                $('#cdnivel').val( data.nivel );
                if( data.ativo == 'S' ){
                    $('#ativo').prop("checked", true);
                }else {
                    $('#ativo').prop("checked", false);
                }
            }
        })

    }
}


$('#login').on('blur', function () {
    var login = $(this).val();
  $.ajax({
      url   : 'function/usuario.php',
      type  : 'post',
      dataType: 'json',
      data : {
          acao : 'V',
          login : login
      },
      success : function (data) {
          console.log("Success: "+data.success);
          if( data.success === 1 ){
              colorirCampo( "login", "" );
              $('span.login-error').text("");
              $('.btn-salvar').attr("disabled",false);
              console.log("Enable");
          }else{
              $('#login').focus();
              colorirCampo( "login", "red" );
              $('span.login-error').text("O login informado já está sendo usado");
              $('.btn-salvar').attr("disabled",true);


          }
      }

  });
});


$('#senha').on('blur', function () {
   validarSenha();
   validarcampos();
});

$('#senha').on('keyup', function () {
    validarSenha();
    validarcampos();
});

$('#repetir').on('blur', function () {
    validarSenha();
});

$('#repetir').on('keyup', function () {
    validarSenha();
    validarcampos();
});

$('.btn-cancelar').on('click', function () {
   $('.modal-question').modal('show');
});

$('.btn-sim').on('click', function () {
    location.href = "usuarios.php";
});



$('.btn-salvar').on('click',function () {
    if( validarcampos() ){
        var acao  = $('#acao').val();
        var id    = $('#id').val();
        var nome  = $('#nome').val();
        var login = $('#login').val();
        var senha = $('#senha').val();
        var nivel = $('#nivel').val();
        var check = $('#ativo');
        var ativo = 'N';
        console.log("Nao Checado");
        if( check.is(":checked") ){
            console.log("Checado");
            ativo = 'S';
        }

        $.ajax({
            url   : 'function/usuario.php',
            type  : 'post',
            dataType : 'json',
            beforeSend : aguardando,
            data : {
                nome : nome,
                login : login,
                senha : senha,
                ativo : ativo,
                acao  : acao,
                nivel : nivel,
                id    : id
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


function validarSenha() {

    var senha = $("#senha").val();
    var resenha = $("#repetir").val();
    if( senha.length < 6 ){
        $("span.aviso-senha").text("A deve ser no mínimo 6 dígitos");
        colorirCampo( "senha", "red" );
        $("#senha").focus();
        $('.btn-salvar').attr("disabled", true);
        return false;
    }else{
        $('span.aviso-senha').text('');
        if( senha == resenha ){
            colorirCampo( "senha", "" );
            colorirCampo( "repetir", "" );
            $('span.aviso-senha').text('');
            $('.btn-salvar').attr("disabled", false);
            return true;
        }else{
            $('span.aviso-senha').text('As senhas não são iguais');
            colorirCampo( "senha", "red" );
            colorirCampo( "repetir", "red" );
            $('.btn-salvar').attr("disabled", true);
            return false;
        }
    }


}




function getUsuarios() {
    $('.tbody').find( 'tr' ).remove();
    $.ajax({
        url  : 'function/usuario.php',
        type : 'post',
        dataType : 'json',
        data : {
            acao : 'U',
        },
        success: function (data) {

            $.each( data.usuarios, function (i, j) {

                var check = "";
                if( j.ativo == "S" ){
                    check = "<i class='fa fa-check'></i>"
                }
                $('.tbody').append(
                    "<tr>"+
                        "<td>"+ j.id +"</td>"+
                        "<td>"+ j.name +"</td>"+
                        "<td>"+ j.login +"</td>"+
                        "<td>"+ j.nivel +"</td>"+
                        "<td>"+ check +"</td>"+
                        "<td>" +
                            "<a href='#editar' class='btn btn-warning btn-editar' title='Editar' data-id='"+ j.id +"'><i class='fa fa-pencil-square-o'></i> Editar </a> &nbsp;" +
                            "<a href='#excluir' class='btn btn-danger btn-excluir' title='Excluir' data-id='"+ j.id +"' data-nome='"+ j.name +"'><i class='fa fa-times'></i> Excluir</a>" +
                        "</td>"+
                    "</tr>"


                );
            } );

            $('.btn-editar').on('click', function () {
                console.log("Editar");
                var id = $(this).data('id');
                var form = $('<form method="post" action="usuarioalt.php">'+
                    '<input type="hidden" name="id" value="'+ id +'" />'+
                    '</form>');
                $('body').append(form);
                form.submit();
            });

            $('.btn-excluir').on('click', function () {
                console.log("Editar");
                var id = $(this).data('id');
                var nome = $(this).data('nome');
                $('span.user-nome').text(nome);
                $('.modal-question').modal('show');
                $('.btn-sim').on('click', function () {
                    $.ajax({
                        url  : 'function/usuario.php',
                        type : 'post',
                        dataType: 'json',
                        befereSend : aguardando,
                        data : {
                            acao : 'E',
                            id   : id
                        },
                        success : function (data) {

                            $('.progress').fadeOut();
                            if( data.success === 1 ){
                                msgSucesso();
                            }else{
                                erroSend();
                            }
                        }
                    });
                });


            });

        }
    });

}

function validarcampos() {

    var nome = $('#nome').val();
    var login = $('#login').val();
    var senha = $('#senha').val();
    var resenha = $('#repetir').val();

    if( (nome != "") && ( login != "" ) && ( senha != "" ) && ( resenha != "" ) && (validarSenha()) ){
        colorirCampo( "nome", "" );
        colorirCampo( "login", "" );
        colorirCampo( "senha", "" );
        colorirCampo( "repitir", "" );
        return true;
    }else{
        if( nome == "" ){
            colorirCampo( "nome", "red" );
        }

        if( login == ""){
            colorirCampo( "login", "red" );
        }

        if( senha == "" ){
            colorirCampo( "senha", "red" );
        }

        if( resenha == "" ){
            colorirCampo( "repetir", "red" );
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

function msgSucesso() {
    var mensagem = $('.mensagem');
    mensagem.empty().html("<p class='alert alert-success'><strong>Parab&eacute;ns</strong> Opera&ccedil;&atilde;o realizada com sucesso! </p>").fadeIn();
    setTimeout(function () {
        location.href = "usuarios.php";
    },3000);
}

function comboNivel(  ) {
    var comboNivel = $('#nivel');
    $.ajax({
        url : 'function/nivel.php',
        dataType : 'json',
        type: 'post',
        data : {
            acao : 'L'
        },
        success: function (data) {

            $.each( data.objetos, function (i, j) {
                comboNivel.append( $('<option />').val( j.id ).text( j.name ) );
            } );
            var cdCombo = $('#cdnivel').val();
            if( cdCombo > 0 ){
                comboNivel.val( cdCombo );
            }

        }
    });
}
