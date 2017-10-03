<?php
/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 03/10/2017
 * Time: 13:59
 */

$acao = $_POST['acao'];


function registrar_compra( $pessoa, $item, $valor, $pago, $item ){
    require_once "../controller/class.registro_controller.php";
    $registro['pessoa'] = $pessoa;
    $registro['item']   = $item;
    $registro['valor']  = $valor;
    $registro['pago']   = $pago;
    $registro['qtde']   = $pago;

    $registro_Controller = new registro_controller();
    $teste = $registro_Controller->insert( $registro );

    if( $teste )
       echo json_encode( array( "retorno" => 1 ) );
    else
        echo json_encode( array( "retorno" => 0 ) );

}


function registrar_pagamento( $pago, $registro ){
    require_once "../controller/class.registro_controller.php";
    $registro['registro'] = $registro;
    $registro['pago']   = $pago;

    $registro_Controller = new registro_controller();
    $teste = $registro_Controller->update( $registro );

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
            "cracha"  => $registro->getPessoa()->getNrCracha(),
            "pessoa"  => $registro->getPessoa()->getNmPessoa(),
            "empresa" => $registro->getNmPago(),
            "valor"   => $registro->getVlPreco(),
        );

    }

    echo json_encode( $registros );


}