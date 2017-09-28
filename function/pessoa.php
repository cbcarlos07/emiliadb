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
$nr_cracha      = "";
$empresa        = "";
$nr_cep         = "";
$nr_casa        = "";
$ds_complemento = "";
$id = 0;
if( isset( $_POST['nome'] ) ){
    $nome = $_POST['nome'];
}

if( isset( $_POST['id'] ) ){
    $id = $_POST['id'];
}

if( isset( $_POST['cracha'] ) ){
    $nr_cracha = $_POST['cracha'];
}

if( isset( $_POST['empresa'] ) ){
    $empresa = $_POST['empresa'];
}

if( isset( $_POST['cep'] ) ){
    $nr_cep = $_POST['cep'];
}

if( isset( $_POST['casa'] ) ){
    $nr_casa = $_POST['casa'];
}

if( isset( $_POST['complemento'] ) ){
    $ds_complemento = $_POST['complemento'];
}


switch ( $acao ){

    case 'L':
        getListObj();
        break;
    case 'I':
        inserir( $nome, $nr_cracha,$empresa, $nr_cep, $nr_casa, $complemento );
        break;

    case 'G':
        getObj( $id );
        break;
    case 'A':
        update( $id, $nome, $nr_cracha,$empresa, $nr_cep, $nr_casa, $complemento );
        break;
    case 'E':
        excluir( $id );
        break;




}

function getListObj(){
    require_once "../controller/class.pessoa_controller.php";
    require_once "../services/class.pessoaListIterator.php";
    require_once "../model/class.pessoa.php";

    $oc = new pessoa_controller();
    $lista = $oc->listaPessoa( '%%' );
    $objList = new pessoaListIterator( $lista );
    $array = array();

    while ( $objList->hasNextPessoa() ){
        $obj = $objList->getNextPessoa();
        $array[] = array(
            "id"     => $obj->getCdPessoa(),
            "nome"   => $obj->getNmPessoa(),
            "empresa"   => $obj->getEmpresa(),

        );
    }
    echo json_encode( array( "objetos" => $array ) );


}

function inserir ( $nome, $cracha,$empresa, $cep, $casa, $complemento ){
    require_once "../controller/class.pessoa_controller.php";
    require_once "../model/class.pessoa.php";

    $obj = new pessoa();
    $obj->setNmPessoa( $nome );
    $obj->setNrCracha( $cracha );
    $obj->setEmpresa( $empresa );
    $obj->setNrCep( $cep );
    $obj->setNrCasa( $casa );
    $obj->setDsComplemento( $complemento );
    $oc = new pessoa_controller();
    $teste = $oc->insert( $obj );
    if( $teste ){

        echo json_encode( array( "sucesso" => 1 ) );

    }
    else{

        echo json_encode( array( "sucesso" => 0 ) );

    }
}

function update ( $id, $nome, $cracha,$empresa, $cep, $casa, $complemento  ){
    require_once "../controller/class.pessoa_controller.php";
    require_once "../model/class.pessoa.php";

    $obj = new pessoa();
    $obj->setNmPessoa( $nome );
    $obj->setNrCracha( $cracha );
    $obj->setEmpresa( $empresa );
    $obj->setNrCep( $cep );
    $obj->setNrCasa( $casa );
    $obj->setDsComplemento( $complemento );
    $obj->setCdPessoa( $id );
    $oc = new pessoa_controller();
    $teste = $oc->update( $obj );
    if( $teste ){

        echo json_encode( array( "sucesso" => 1 ) );

    }
    else{

        echo json_encode( array( "sucesso" => 0 ) );

    }
}

function getObj($id){
    require_once "../controller/class.pessoa_controller.php";
    require_once "../model/class.pessoa.php";

    $oc = new pessoa_controller(); //oc Objeto Controller
    $obj = $oc->getPessoa( $id );

    $array['id']          = $obj->getCdPessoa();
    $array['nome']        = $obj->getNmPessoa();
    $array['cracha']      = $obj->getNrCracha();
    $array['cep']         = $obj->getNrCep();
    $array['casa']        = $obj->getNrCasa();
    $array['complemento'] = $obj->getDsComplemento();

    echo json_encode( $array );

}

function excluir( $id ){
    require_once "../controller/class.pessoa_controller.php";
    $oc = new pessoa_controller();
    $teste = $oc->delete( $id );
    if( $teste ){
        echo json_encode( array( "success" => 1) );
    }else{
        echo json_encode( array( "success" => 0) );
    }
}
