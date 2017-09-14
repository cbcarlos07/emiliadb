<?php

/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 19/08/17
 * Time: 22:55
 */
class empresa_controller
{
    public function insert ( empresa $empresa ){
        require_once "../dao/class.empresa_dao.php";
        $objDao = new empresa_dao();
        $teste = $objDao->insert( $empresa );
        return $teste;
    }

    public function update ( empresa $empresa ){
        require_once "../dao/class.empresa_dao.php";
        $objDao = new empresa_dao();
        $teste = $objDao->update( $empresa );
        return $teste;
    }

    public function delete ( $empresa ){
        require_once "../dao/class.empresa_dao.php";
        $objDao = new empresa_dao();
        $teste = $objDao->delete( $empresa );
        return $teste;
    }


    public function listaEmpresa( $empresa ){
        require_once "../dao/class.empresa_dao.php";
        $objDao = new empresa_dao();
        $teste = $objDao->listaEmpresa( $empresa );
        return $teste;
    }

    public function getEmpresa( $empresa ){
        require_once "../dao/class.empresa_dao.php";
        $objDao = new empresa_dao();
        $teste = $objDao->getEmpresa( $empresa );
        return $teste;
    }

}