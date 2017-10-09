/**
 * Created by carlos on 19/08/17.
 */

$(document).ready(function () {
   $('.progress').fadeOut();
   getUser( $('#id').val() );
});

function getUser( id ) {
   // console.log("Codigo para alterar: "+id);
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
                var nomeCompleto = data.nome;
                //console.log("Nome completo: "+nomeCompleto);
                var firstName = nomeCompleto.split(" ");
                //console.log("Primeiro nome: "+firstName[0]);
                $('span.nome-user').text( firstName[0] );
            }
        })

    }
}


$('.btn-login').on( 'click', function () {
   
    if( verificarCampos() ){

        var usuario = $('#usuario').val();
        var senha   = $('#pwd').val();
        var check = $('#lembrar');
        var lembrar = 'N';
        if( check.checked ){
            lembrar = 'S';
        }

        $.ajax({
            url  : 'function/usuario.php',
            type : 'post',
            dataType : 'json',
            beforeSend : carregando,
            data     : {
                acao  : 'L',
                login : usuario,
                senha : senha,
                lembrar : lembrar
            },
            success : function (data) {
                $('.progress').fadeOut();
                if( data.sucesso === 1 ){
                    sucesso(  );
                }else if( data.sucesso === 0 ){
                    var form = $('<form action="alterarSenha.php" method="post">' +
                                    '<input type="hidden" value="'+ data.codigo +'" name="id" />'+
                                '</form>');
                    $('body').append( form );
                    form.submit();
                }else{
                    errosend();
                }

            }
        })

    }
    
} );


function verificarCampos() {
    var usuario = $('#usuario').val();
    var senha   = $('#pwd').val();

    if( ( usuario != "" ) && ( senha != "" ) ){
        corCampo( 'usuario', '' );
        corCampo( 'pwd', '' );
        return true;

    }
    else{

        if( usuario == "" ){
            corCampo( 'usuario', 'red' );
        }

        if( senha == "" ){
            corCampo( 'pwd', 'red' );
        }
        return false;

    }
}

function corCampo( id, cor ) {

    $('input[id="'+id+'"]').css( 'border-color', cor );

}


function carregando(){
    var mensagem = $('.mensagem');
    //alert('Carregando: '+mensagem);
 //   $('.progress').fadeIn();


}


function sucesso(){
    var mensagem = $('.mensagem');
    mensagem.empty().html('<p class="alert alert-success"><strong>OK.</strong> Estamos redirecionando </p>').fadeIn("fast");
    var url = 'lancamento.php';
    var form = $('<form action="' + url + '" method="post">' +

        '</form>');
    $('body').append(form);
    form.submit();

    //   location.href = "usuario?acao=S";

    //window.setTimeout()
    //delay(2000);
}

function errosend(){
    var mensagem = $('.mensagem');
    mensagem.empty().html('<p class="alert alert-danger"><strong>Opa!</strong> Por favor, verifique seu login e/ou sua senha</p>').fadeIn("fast");
}

$('#pwd').on('keyup', function () {
    validarSenha();

});

$('#pwd1').on('keyup', function () {
    validarSenha();

});

function validarSenha() {
    var senha = $('#pwd').val();
    var senha1 = $('#pwd1').val();
    if( senha.length < 6 ){
        $('span.alerta-senha').text('A senha tem que ser no mínimo 6 dígitos');
        coloriCampo( "pwd", "red" );
        $('.btn-new-pwd').attr('disabled', true);
    }else{
        if( senha == senha1 ){
            $('.btn-new-pwd').attr('disabled', false);
            coloriCampo( "pwd", "" );
            coloriCampo( "pwd1", "" );
            $('span.alerta-senha').text('');
            $('span.alerta-senha1').text('');


        }else{
            $('span.alerta-senha').text('');
            $('span.alerta-senha1').text('As senhas não coincidem');
            coloriCampo( "pwd1", "red" );
            $('.btn-new-pwd').attr('disabled', "disa");
        }
    }

}

function coloriCampo( id, cor) {
    $('input[id="'+ id +'"]').css( 'border-color', cor );
}

$('.btn-new-pwd').on('click', function () {
        var id = $('#id').val();
        var senha = $('#pwd').val();
      //  console.log("js Senha: "+senha);

        $.ajax({
            url  : 'function/usuario.php',
            dataType : 'json',
            type : 'post',
            beforeSend : carregando,
            data : {
                acao : 'S',
                id   : id,
                senha : senha
            },
            success : function (data) {
                if( data.success === 1 ){
                    sucesso();
                }else{
                    errosend();
                }
            }
        });
});

$('#pwd').on('keypress', function(e){
    if (e.keyCode == 13) {
        e.preventDefault();
        $(".btn-login").click();
    }
});
