/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var valor = 0;
$('#nascimento').on('focusout',function (){
    calcularIdade();
});

function calcularIdade() {
    var hoje = new Date();
    console.log("Hoje: "+hoje);
    var data = document.getElementById("nascimento").value;
    var dataNasc = data.split("/");
    var dia = dataNasc[0];
    var mes = dataNasc[1];
    var ano = dataNasc[2];
    console.log("Data do campo: "+data);
    var nascimento = new Date(mes +"/"+dia+"/"+ano);
    console.log("Nascimento: "+nascimento);
    var campoidade = document.getElementById("idade");
    var diferencaAnos = hoje.getFullYear() - nascimento.getFullYear();
    if ( new Date(hoje.getFullYear(), hoje.getMonth(), hoje.getDate()) <
        new Date(hoje.getFullYear(), nascimento.getMonth(), nascimento.getDate()) )
        diferencaAnos--;
    //return diferencaAnos;
    console.log("Idade:"+diferencaAnos);
    campoidade.value = diferencaAnos;


}



