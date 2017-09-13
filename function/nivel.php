<?php
/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 19/08/17
 * Time: 23:12
 */
require_once "../include/error.php";
$acao = $_POST['acao'];

$descricao = "";
$id = 0;
if( isset( $_POST['descricao'] ) ){
    $descricao = $_POST['descricao'];
}

if( isset( $_POST['id'] ) ){
    $id = $_POST['id'];
}


switch ( $acao ){

    case 'L':
        getListObj();
        break;
    case 'I':
        inserir( $descricao );
        break;

    case 'G':
        getObj( $id );
        break;
    case 'A':
        update( $id, $descricao );
        break;
    case 'E':
        excluir( $id );
        break;




}

function getListObj(){
    require_once "../controller/class.nivel_controller.php";
    require_once "../services/class.nivelListIterator.php";
    require_once "../model/class.nivel.php";

    $oc = new nivel_controller();
    $lista = $oc->listaNivel( '%%' );
    $objList = new nivelListIterator( $lista );
    $array = array();

    while ( $objList->hasNextNivel() ){
        $obj = $objList->getNextNivel();
        $array[] = array(
            "id"     => $obj->getCdNivel(),
            "name"   => $obj->getDsNivel()
        );
    }
    echo json_encode( array( "objetos" => $array ) );


}

function inserir ( $descricao ){
    require_once "../controller/class.nivel_controller.php";
    require_once "../model/class.nivel.php";

    $obj = new nivel();
    $obj->setDsNivel( $descricao );
    $oc = new nivel_controller();
    $teste = $oc->insert( $obj );
    if( $teste ){

        echo json_encode( array( "sucesso" => 1 ) );

    }
    else{

        echo json_encode( array( "sucesso" => 0 ) );

    }
}

function update ( $id, $descricao ){
    require_once "../controller/class.nivel_controller.php";
    require_once "../model/class.nivel.php";

    $obj = new nivel();
    $obj->setDsNivel( $descricao );
    $obj->setCdNivel( $id );
    $oc = new nivel_controller();
    $teste = $oc->update( $obj );
    if( $teste ){

        echo json_encode( array( "sucesso" => 1 ) );

    }
    else{

        echo json_encode( array( "sucesso" => 0 ) );

    }
}

function getObj($id){
    require_once "../controller/class.nivel_controller.php";
    require_once "../model/class.nivel.php";

    $oc = new nivel_controller(); //oc Objeto Controller
    $obj = $oc->getNivel( $id );

    $array['id']         = $obj->getCdNivel();
    $array['descricao']  = $obj->getDsNivel();

    echo json_encode( $array );

}

function excluir( $id ){
    require_once "../controller/class.nivel_controller.php";
    $oc = new nivel_controller();
    $teste = $oc->delete( $id );
    if( $teste ){
        echo json_encode( array( "success" => 1) );
    }else{
        echo json_encode( array( "success" => 0) );
    }
}
