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
$empresa        = 0;
$nr_cep         = "";
$nr_casa        = "";
$ds_complemento = "";
$id = 0;
$telefone = "";

if( isset( $_POST['telefone'] ) ){
    $telefone = $_POST['telefone'];
}

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
        inserir( $nome, $nr_cracha,$empresa, $nr_cep, $nr_casa, $ds_complemento, $telefone );
        break;

    case 'G':
        getObj( $id );
        break;
    case 'A':
        update( $id, $nome, $nr_cracha,$empresa, $nr_cep, $nr_casa, $ds_complemento, $telefone );
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

function inserir ( $nome, $cracha,$empresa, $cep, $casa, $complemento, $telefone ){
    require_once "../controller/class.pessoa_controller.php";
    require_once "../controller/class.telefone_controller.php";
    require_once "../model/class.pessoa.php";
    require_once "../model/class.telefone.php";

    $telefones = json_decode( $telefone );

    $obj = new pessoa();
    $obj->setNmPessoa( $nome );
    $obj->setNrCracha( $cracha );
    $obj->setEmpresa( $empresa );
    $subs = array(".","-");
    $newCEP = str_replace( $subs, "", $cep );
    $obj->setNrCep( $newCEP );
    $obj->setNrCasa( $casa );
    $obj->setDsComplemento( $complemento );
    $oc = new pessoa_controller();
    $teste = $oc->insert( $obj );

    $phoneObj = new telefone();
    $tc       = new telefone_controller();

    if( $teste > 0 ){

        foreach ( $telefones as $item => $value ){
            $phoneObj->setPessoa( $teste );
            $phoneObj->setNrTelefone( $value->{'Telefone'} );
            $phoneObj->setDsObservacao( $value->{'Obs'} );
            $phoneObj->setTpTelefone( $value->{'Tipo'} );
            $result = $tc->insert( $phoneObj );

        }



    }

    if( $teste > 0 ){
        echo json_encode( array( "sucesso" => 1, "cliente" => $teste ) );
    }
    else{

        echo json_encode( array( "sucesso" => 0 ) );

    }
}

        function update ( $id, $nome, $cracha,$empresa, $cep, $casa, $complemento, $telefone  ){
            require_once "../controller/class.pessoa_controller.php";
            require_once "../controller/class.telefone_controller.php";
            require_once "../model/class.pessoa.php";
            require_once "../model/class.telefone.php";

            $telefones = json_decode( $telefone );

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
            $phoneObj = new telefone();
            $tc       = new telefone_controller();

                if( $teste > 0 ) {
                    $removeTelefone = $tc->delete( $teste );
                    foreach ($telefones as $item => $value) {
                        $phoneObj->setPessoa( $teste );
                        $phoneObj->setNrTelefone($value->{'Telefone'});
                        $phoneObj->setDsObservacao($value->{'Obs'});
                        $phoneObj->setTpTelefone($value->{'Tipo'});
                        $result = $tc->insert($phoneObj);

                    }

                }

            if( $teste > 0 ){
                echo json_encode( array( "sucesso" => 1, "cliente" => $teste ) );
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
