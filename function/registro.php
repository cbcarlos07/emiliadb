<?php
/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 03/10/2017
 * Time: 13:59
 */

$acao = $_POST['acao'];
$registro = 0;
$pessoa = 0;
$item   = 0;
$valor  = 0;
$pago   = "";
$qtde   = 0;
$cracha   = "";
$itens = "";

if( isset( $_POST['registro'] ) )
    $registro = $_POST['registro'];

if( isset( $_POST['pessoa'] ) )
    $pessoa = $_POST['pessoa'];

if( isset( $_POST['item'] ) )
    $item = $_POST['item'];

if( isset( $_POST['valor'] ) )
    $valor = $_POST['valor'];

if( isset( $_POST['pago'] ) )
    $pago = $_POST['pago'];

if( isset( $_POST['qtde'] ) )
    $qtde = $_POST['qtde'];

if( isset( $_POST['cracha'] ) )
    $cracha = $_POST['cracha'];

if( isset( $_POST['itens'] ) )
    $itens = $_POST['itens'];





switch ( $acao ){
    case 'R':
        registrar_compra( $pessoa,  $pago, $itens );
        break;
    case 'P':
        registrar_pagamento( $pago, $registro );
        break;
    case 'L':
        listaRegistro( $pessoa, $cracha );
        break;
    case 'I':
        listaITem( $pessoa );
        break;

}


function registrar_compra( $pessoa,  $pago, $itens ){
    require_once "../include/error.php";
    require_once "../controller/class.registro_controller.php";
    $registro_Controller = new registro_controller();

    $arr = json_decode( $itens );

    $teste =  false;
    foreach ( $arr as $a => $b ) {
      //  echo "Pessoa: $pessoa \n";
        $registro['pessoa'] = $pessoa;
        $registro['item'] = $b->{'#'};
        $item = $b->{'#'};
       // echo "Produto: $item \n";
        $valor = str_replace("R$ ", "", str_replace(",", ".", $b->{'Valor'}));
       // echo "Valor: $valor \n";
        $registro['valor'] = $valor;
        $registro['pago'] = $pago;
       // echo "Pago: $pago \n";
        $registro['qtde'] = $b->{'Qtde'};
        $qtde = $b->{'Qtde'};
       // echo "Qtde: $qtde \n";



        $teste = $registro_Controller->insert($registro);
    }
    if( $teste )
       echo json_encode( array( "retorno" => 1 ) );
    else
        echo json_encode( array( "retorno" => 0 ) );

}


function registrar_pagamento( $pago, $registro ){
   // echo "Pago: $pago \n";
   // echo "Registro: $registro \n";
    require_once "../controller/class.registro_controller.php";
   // echo "Registro $registro \n";
    $reg['registro'] = $registro;
    $reg['pago']   = $pago;

    $registro_Controller = new registro_controller();
    $teste = $registro_Controller->update( $reg );

    if( $teste )
        echo json_encode( array( "retorno" => 1 ) );
    else
        echo json_encode( array( "retorno" => 0 ) );

}

function listaRegistro( $pessoa, $cracha ){
    require_once "../controller/class.registro_controller.php";
    require_once "../services/class.registroListIterator.php";
    $registro_Controller = new registro_controller();
    $lista = $registro_Controller->listaRegistro( $pessoa, $cracha );
    $registros  = array();
    $reg_in = new registroListIterator( $lista );
    while ( $reg_in->hasNextRegistro() ){

        $registro = $reg_in->getNextRegistro();
        $registros[] = array(
            "codigo"  => $registro->getCdRegPessoa(),
            "cracha"  => $registro->getPessoa()->getNrCracha(),
            "pessoa"  => $registro->getPessoa()->getNmPessoa(),
            "empresa" => $registro->getSnPago(),
            "valor"   => $registro->getVlPreco(),
        );

    }

    echo json_encode( $registros );


}

function listaITem ( $pessoa ){
    require_once "../controller/class.registro_controller.php";
    require_once "../services/class.registroListIterator.php";
    $registro_Controller = new registro_controller();
    //echo "Codigo: $pessoa \n";
    $lista = $registro_Controller->listaRegistroItem( $pessoa );
    $registros  = array();
    $reg_in = new registroListIterator( $lista );
    while ( $reg_in->hasNextRegistro() ){

        $registro = $reg_in->getNextRegistro();
        $registros[] = array(
            "codigo"  => $registro->getCdRegPessoa(),
            "cracha"  => $registro->getPessoa()->getNrCracha(),
            "pessoa"  => $registro->getPessoa()->getNmPessoa(),
            "empresa" => $registro->getSnPago(),
            "produto" => $registro->getItem(),
            "qtde"    => $registro->getQtCompra(),
            "valor"   => $registro->getVlPreco(),
            "data"   => $registro->getDtRegistro(),
        );

    }

    echo json_encode( $registros );
}