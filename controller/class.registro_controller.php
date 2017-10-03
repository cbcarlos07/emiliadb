<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 03/10/2017
 * Time: 14:02
 */
class registro_controller
{
    public function insert ( $registro ){
        require_once "../dao/class.registro_dao.php";
        $rd = new registro_dao();
        $teste = $rd->insert( $registro );
        return $teste;
    }

    public function update ( $registro ){
        require_once "../dao/class.registro_dao.php";
        $rd = new registro_dao();
        $teste = $rd->update( $registro );
        return $teste;
    }

    public function listaRegistro( $pessoa, $cracha ){
        require_once "../dao/class.registro_dao.php";
        $rd = new registro_dao();
        $teste = $rd->listaRegistro( $pessoa, $cracha );
        return $teste;
    }

    public function listaRegistroItem( $pessoa ){
        require_once "../dao/class.registro_dao.php";
        $rd = new registro_dao();
        $teste = $rd->listaRegistroItem( $pessoa );
        return $teste;
    }

}