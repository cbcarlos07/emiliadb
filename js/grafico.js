/**
 * Created by carlos.bruno on 21/08/2017.
 */
$(document).ready(function () {

    var especialidade = [];
    var totais = [];
    $.ajax({
        url  : 'function/especialidade.php',
        type : 'post',
        dataType : 'json',
        data : {
            acao : 'Z'
        }
        ,success : function (data) {
            $.each( data, function (i, j) {
                especialidade.push( j.espec );
                totais.push( j.total );
            } )

         //   console.log(especialidade);
        }
    })
});