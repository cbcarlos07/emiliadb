<?php
/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 19/08/17
 * Time: 23:12
 */
require_once "../include/error.php";
$acao = $_POST['acao'];

$nome = "";
$id = 0;
if( isset( $_POST['nome'] ) ){
    $nome = $_POST['nome'];
}

if( isset( $_POST['id'] ) ){
    $id = $_POST['id'];
}




switch ( $acao ){

    case 'L':
        getListObj();
        break;
    case 'I':
        inserir( $nome );
        break;

    case 'G':
        getObj( $id );
        break;
    case 'A':
        update( $id, $nome);
        break;
    case 'E':
        excluir( $id );
        break;




}

function getListObj(){
    require_once "../controller/class.empresa_controller.php";
    require_once "../services/class.empresaListIterator.php";
    require_once "../model/class.empresa.php";

    $oc = new empresa_controller();
    $lista = $oc->listaEmpresa( '%%' );
    $objList = new empresaListIterator( $lista );
    $array = array();

    while ( $objList->hasNextEmpresa() ){
        $obj = $objList->getNextEmpresa();
        $array[] = array(
            "id"     => $obj->getCdEmpresa(),
            "name"   => $obj->getDsEmpresa()
        );
    }
    echo json_encode( array( "objetos" => $array ) );


}

function inserir ( $nome ){
    require_once "../controller/class.empresa_controller.php";
    require_once "../model/class.empresa.php";

    $obj = new empresa();
    $obj->setDsEmpresa( $nome );
    $oc = new empresa_controller();
    $teste = $oc->insert( $obj );
    if( $teste ){

        echo json_encode( array( "sucesso" => 1 ) );

    }
    else{

        echo json_encode( array( "sucesso" => 0 ) );

    }
}

function update ( $id, $nome ){
    require_once "../controller/class.empresa_controller.php";
    require_once "../model/class.empresa.php";

    $obj = new empresa();
    $obj->setCdEmpresa( $id );
    $obj->setDsEmpresa( $nome );
    $oc = new empresa_controller();
    $teste = $oc->update( $obj );
    if( $teste ){

        echo json_encode( array( "sucesso" => 1 ) );

    }
    else{

        echo json_encode( array( "sucesso" => 0 ) );

    }
}

function getObj($id){
    require_once "../controller/class.empresa_controller.php";
    require_once "../model/class.empresa.php";

    $oc = new empresa_controller(); //oc Objeto Controller
    $obj = $oc->getEmpresa( $id );

    $array['id']         = $obj->getCdEmpresa();
    $array['nome']       = $obj->getDsEmpresa();

    echo json_encode( $array );

}

function excluir( $id ){
    require_once "../controller/class.empresa_controller.php";
    $oc = new empresa_controller();
    $teste = $oc->delete( $id );
    if( $teste ){
        echo json_encode( array( "success" => 1) );
    }else{
        echo json_encode( array( "success" => 0) );
    }
}
