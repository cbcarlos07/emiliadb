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
$valor     = "";
$id = 0;
if( isset( $_POST['descricao'] ) ){
    $descricao = $_POST['descricao'];
}

if( isset( $_POST['id'] ) ){
    $id = $_POST['id'];
}

if( isset( $_POST['valor'] ) ){
    $valor = $_POST['valor'];
}


switch ( $acao ){

    case 'L':
        getListObj();
        break;
    case 'I':
        inserir( $descricao, $valor );
        break;

    case 'G':
        getObj( $id );
        break;
    case 'A':
        update( $id, $descricao, $valor );
        break;
    case 'E':
        excluir( $id );
        break;




}

function getListObj(){
    require_once "../controller/class.item_controller.php";
    require_once "../services/class.itemListIterator.php";
    require_once "../model/class.item.php";

    $oc = new item_controller();
    $lista = $oc->listaItem( '%%' );
    $objList = new itemListIterator( $lista );
    $array = array();

    while ( $objList->hasNextItem() ){
        $obj = $objList->getNextItem();
        $array[] = array(
            "id"     => $obj->getCdItem(),
            "descricao"   => $obj->getDsProduto(),
            "valor"   => $obj->getVlPreco(),

        );
    }
    echo json_encode( array( "objetos" => $array ) );


}

function inserir ( $descricao, $preco ){
    require_once "../controller/class.item_controller.php";
    require_once "../model/class.item.php";

    $obj = new item();
    $obj->setDsProduto( $descricao );
    $obj->setVlPreco( $preco );
    $oc = new item_controller();
    $teste = $oc->insert( $obj );
    if( $teste ){

        echo json_encode( array( "sucesso" => 1 ) );

    }
    else{

        echo json_encode( array( "sucesso" => 0 ) );

    }
}

function update ( $id, $descricao, $preco ){
    require_once "../controller/class.item_controller.php";
    require_once "../model/class.item.php";

    $obj = new item();
    $obj->setDsProduto( $descricao );
    $obj->setVlPreco( $preco );
    $obj->setCdItem( $id );
    $oc = new item_controller();
    $teste = $oc->update( $obj );
    if( $teste ){

        echo json_encode( array( "sucesso" => 1 ) );

    }
    else{

        echo json_encode( array( "sucesso" => 0 ) );

    }
}

function getObj($id){
    require_once "../controller/class.item_controller.php";
    require_once "../model/class.item.php";

    $oc = new item_controller(); //oc Objeto Controller
    $obj = $oc->getItem( $id );

    $array['id']         = $obj->getCdItem();
    $array['descricao']  = $obj->getDsProduto();
    $array['valor']      = $obj->getVlPreco();

    echo json_encode( $array );

}

function excluir( $id ){
    require_once "../controller/class.item_controller.php";
    $oc = new item_controller();
    $teste = $oc->delete( $id );
    if( $teste ){
        echo json_encode( array( "success" => 1) );
    }else{
        echo json_encode( array( "success" => 0) );
    }
}
