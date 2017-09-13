<?php

/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 19/08/17
 * Time: 22:55
 */
class nivel_controller
{
    public function insert ( nivel $nivel ){
        require_once "../dao/class.nivel_dao.php";
        $objDao = new nivel_dao();
        $teste = $objDao->insert( $nivel );
        return $teste;
    }

    public function update ( nivel $nivel ){
        require_once "../dao/class.nivel_dao.php";
        $objDao = new nivel_dao();
        $teste = $objDao->update( $nivel );
        return $teste;
    }

    public function delete ( $nivel ){
        require_once "../dao/class.nivel_dao.php";
        $objDao = new nivel_dao();
        $teste = $objDao->delete( $nivel );
        return $teste;
    }


    public function listaNivel( $nivel ){
        require_once "../dao/class.nivel_dao.php";
        $objDao = new nivel_dao();
        $teste = $objDao->listaNivel( $nivel );
        return $teste;
    }

    public function getNivel( $nivel ){
        require_once "../dao/class.nivel_dao.php";
        $objDao = new nivel_dao();
        $teste = $objDao->getNivel( $nivel );
        return $teste;
    }

}